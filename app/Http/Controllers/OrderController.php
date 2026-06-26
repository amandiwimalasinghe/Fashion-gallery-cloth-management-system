<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function checkout()
    {
        $cartItems = CartItem::where('user_id', Auth::id())->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Your cart is empty!');
        }

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $lineItems = [];
        foreach ($cartItems as $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'lkr',
                    'product_data' => [
                        'name' => $item->product->name,
                    ],
                    'unit_amount' => (int)($item->product->price * 100), // Stripe expects amounts in cents
                ],
                'quantity' => $item->quantity,
            ];
        }

        try {
            $checkout_session = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'],
                'line_items' => $lineItems,
                'mode' => 'payment',
                'success_url' => route('checkout.success'),
                'cancel_url' => route('checkout.cancel'),
            ]);

            return redirect($checkout_session->url);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error creating payment session: ' . $e->getMessage());
        }
    }

    public function checkoutSuccess()
    {
        $cartItems = CartItem::where('user_id', Auth::id())->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('dashboard')->with('error', 'No active session or cart is empty.');
        }

        DB::transaction(function () use ($cartItems) {
            $ordersByDesigner = $cartItems->groupBy(function ($item) {
                return $item->product->user_id;
            });

            foreach ($ordersByDesigner as $designerId => $items) {
                $subtotal = $items->sum(function($item) {
                    return $item->product->price * $item->quantity;
                });

                $total = $subtotal;

                $order = Order::create([
                    'user_id' => Auth::id(),
                    'total_amount' => $total,
                    'status' => 'pending',
                    'payment_method' => 'stripe'
                ]);

                foreach ($items as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item->product_id,
                        'quantity' => $item->quantity,
                        'price' => $item->product->price
                    ]);

                    $product = Product::find($item->product_id);
                    $product->decrement('stock_quantity', $item->quantity);
                }
            }

            CartItem::where('user_id', Auth::id())->delete();
        });

        return redirect()->route('order.success')->with('success', 'Payment successful and order placed!');
    }

    public function checkoutCancel()
    {
        return redirect()->route('cart.index')->with('error', 'Payment was cancelled.');
    }
    public function success()
    {
        return view('orders.success');
    }

    public function myOrders()
    {
        $orders = Order::where('user_id', Auth::id())
                       ->with('items.product') // Load products
                       ->latest()
                       ->paginate(10);

        return view('orders.index', compact('orders'));
    }


    public function markAsComplete($id)
    {
        $order = Order::where('id', $id)->where('user_id', Auth::id())->firstOrFail();


        if($order->status == 'shipped') {
            $order->status = 'completed';
            $order->save();
            return redirect()->back()->with('success', 'Order marked as received! Please leave a review.');
        }

        return redirect()->back()->with('error', 'Order cannot be completed yet. Wait until it is shipped.');
    }

    public function designerOrders()
{
    $orders = Order::whereHas('items.product', function($query) {
        $query->where('user_id', Auth::id());
    })->with(['items.product', 'user'])->latest()->get();

    return view('designer.orders', compact('orders'));
}


    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);



        $order->status = $request->status;
        $order->save();

        return redirect()->back()->with('success', 'Order status updated to ' . $request->status);
    }
}
