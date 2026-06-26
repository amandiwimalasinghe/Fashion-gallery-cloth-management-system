<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;

class TryOnController extends Controller
{


    public function TryOn(Request $request)
    {
        $product = null;
        if ($request->has('product_id')) {
            $product = Product::find($request->product_id);
        }
        return view('\tryon\index', compact('product'));
    }
}
