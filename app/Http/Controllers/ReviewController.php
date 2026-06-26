<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
            'product_id' => 'required|exists:products,id',
            'order_id' => 'required|exists:orders,id',
        ]);

        Review::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            'order_id' => $request->order_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->back()->with('success', 'Thank you for your feedback!');
    }

    public function designerReviews()
{

    $reviews = Review::whereHas('product', function($query) {
        $query->where('user_id', Auth::id());
    })
    ->with(['product', 'user']) 
    ->latest()
    ->paginate(10);

    return view('designer.reviews', compact('reviews'));
}
}
