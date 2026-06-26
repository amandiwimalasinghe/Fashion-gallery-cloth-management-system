<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
class TryOnController extends Controller
{


    public function TryOn(Request $request)
    {
        return view('\tryon\index');

    }
}
