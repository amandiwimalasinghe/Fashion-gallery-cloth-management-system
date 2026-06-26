<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
{
    $cartItems = CartItem::where('user_id', Auth::id())->with('product')->get();


    $subtotal = $cartItems->sum(function($item) {
        return $item->product->price * $item->quantity;
    });


    $shipping = 0;

    
    $total = $subtotal;

    return view('cart.index', compact('cartItems', 'subtotal', 'shipping', 'total'));
}


    public function addToCart(Request $request, $id)
    {
        $product = Product::findOrFail($id);


        $existingItem = CartItem::where('user_id', Auth::id())
                                ->where('product_id', $id)
                                ->first();

        if ($existingItem) {

            $existingItem->quantity += 1;
            $existingItem->save();
        } else {

            CartItem::create([
                'user_id' => Auth::id(),
                'product_id' => $id,
                'quantity' => 1
            ]);
        }

        return redirect()->back()->with('success', 'Product added to cart!');
    }


    public function destroy($id)
    {
        CartItem::where('id', $id)->where('user_id', Auth::id())->delete();
        return redirect()->back()->with('success', 'Item removed from cart.');
    }
}
