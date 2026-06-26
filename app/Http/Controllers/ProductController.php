<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function create()
    {

        if (Auth::user()->role !== 'designer') {
            abort(403, 'Only designers can upload products.');
        }


        return view('products.create');
    }


    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string',
            'stock_quantity' => 'required|integer|min:1',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:5120', // Max 5MB
            'description' => 'nullable|string',
        ]);


        $imagePath = $request->file('image')->store('product-images', 'public');


        Product::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'price' => $request->price,
            'category' => $request->category,
            'stock_quantity' => $request->stock_quantity,
            'size' => $request->size,
            'image' => $imagePath,
            'description' => $request->description,
        ]);


        return redirect()->route('designer.show', Auth::id())->with('success', 'Design uploaded successfully!');
    }


public function edit($id)
{
    $product = Product::findOrFail($id);


    if (Auth::id() !== $product->user_id) {
        abort(403, 'Unauthorized action.');
    }

    return view('products.edit', compact('product'));
}


public function update(Request $request, $id)
{
    $product = Product::findOrFail($id);

    if (Auth::id() !== $product->user_id) {
        abort(403);
    }

    $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'category' => 'required|string',
        'stock_quantity' => 'required|integer|min:1',
        'image' => 'nullable|image|max:5120', 
        'description' => 'nullable|string',
    ]);

    $product->name = $request->name;
    $product->price = $request->price;
    $product->category = $request->category;
    $product->stock_quantity = $request->stock_quantity;
    $product->size = $request->size;
    $product->description = $request->description;


    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('product-images', 'public');
        $product->image = $path;
    }

    $product->save();

    return redirect()->route('designer.show', Auth::id())->with('success', 'Design updated successfully!');
}


public function destroy($id)
{
    $product = Product::findOrFail($id);

    if (Auth::id() !== $product->user_id) {
        abort(403);
    }

    $product->delete();

    return back()->with('success', 'Design deleted successfully!');
}
}
