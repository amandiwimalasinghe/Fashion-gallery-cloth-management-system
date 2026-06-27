<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DesignerController extends Controller
{
    public function show($id)
    {

        $designer = User::where('role', 'designer')->with('products')->findOrFail($id);

        return view('designer.show', compact('designer'));
    }

    public function updateBanner(Request $request)
{

    $request->validate([
        'banner_image' => 'required|image|mimes:jpeg,png,jpg|max:5120',
    ]);

    $user = Auth::user();

    if ($request->hasFile('banner_image')) {

        $path = $request->file('banner_image')->store('banner-images', 'public');


        $user->forceFill([
            'banner_image' => $path
        ])->save();
    }

    return redirect()->back()->with('success', 'Banner updated successfully!');
}



        public function index(Request $request)
        {
            $product = null;
            if ($request->has('product_id')) {
                $product = \App\Models\Product::find($request->product_id);
            }
            return view('customizer.customizer', compact('product'));
        }

        public function saveDesign(Request $request)
            {
                $imageData = $request->input('image');

                if (preg_match('/^data:image\/(\w+);base64,/', $imageData, $type)) {
                    $imageData = substr($imageData, strpos($imageData, ',') + 1);
                    $type = strtolower($type[1]);

                    $imageData = base64_decode($imageData);
                    $fileName = "design_" . Str::random(10) . '.' . $type;


                    Storage::disk('public')->put('generated/' . $fileName, $imageData);

                    return response()->json([
                        'message' => 'Design saved successfully!',
                        'url' => asset('storage/generated/' . $fileName),
                        'filename' => $fileName
                    ]);
                }

                return response()->json(['error' => 'Invalid image data'], 400);
            }
}
