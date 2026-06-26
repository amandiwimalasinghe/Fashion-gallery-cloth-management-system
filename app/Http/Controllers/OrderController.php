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
                'payment_method' => 'cod'
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

    return redirect()->route('order.success');
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
