<?php

namespace App\Http\Controllers;

use App\Models\ProductInquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InquiryController extends Controller
{
   public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'order_id' => 'required',
            'message' => 'required|string|max:1000',
        ]);

        ProductInquiry::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            'order_id' => $request->order_id,
            'message' => $request->message,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Inquiry submitted successfully! Admin will contact you.');
    }

  
    public function adminIndex()
    {
        $inquiries = ProductInquiry::with(['user', 'product'])->latest()->paginate(10);
        return view('admin.inquiries.index', compact('inquiries'));
    }


    public function adminUpdate(Request $request, $id)
    {
        $inquiry = ProductInquiry::findOrFail($id);

        $inquiry->update([
            'admin_reply' => $request->admin_reply,
            'status' => $request->status,
        ]);

        return back()->with('success', 'Inquiry updated successfully!');
    }
}
