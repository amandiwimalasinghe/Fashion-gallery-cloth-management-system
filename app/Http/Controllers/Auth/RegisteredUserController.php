<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
{
    // 1. VALIDATION
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        'role' => ['required', 'in:customer,designer'],
        'phone' => ['required', 'string', 'max:20'],
        'address' => ['required', 'string', 'max:500'],

        // Image Validation: Optional, Must be an image, Types: jpeg,png,jpg, Max size: 2MB (2048 KB)
        'profile_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],

        // Company Data
        'company_name' => ['nullable', 'string', 'max:255'],
        'company_email' => ['nullable', 'email', 'max:255'],
        'company_phone' => ['nullable', 'string', 'max:20'],
    ]);

    // 2. HANDLE IMAGE UPLOAD
    $imagePath = null; 

    if ($request->role === 'designer' && $request->hasFile('profile_image')) {

        $imagePath = $request->file('profile_image')->store('profile-images', 'public');
    }

    // 3. CREATE USER
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role,
        'profile_image' => $imagePath,
        'phone' => $request->phone,
        'address' => $request->address,
        'company_name' => $request->company_name,
        'company_email' => $request->company_email,
        'company_phone' => $request->company_phone,
    ]);

    event(new Registered($user));

    Auth::login($user);

    return redirect(route('dashboard', absolute: false));
}
}
