<x-guest-layout>
    <!-- Header -->
    <div class="mb-6 text-center">
        <div
            class="inline-flex items-center justify-center w-14 h-14 bg-gradient-to-br from-[#d4af37] to-[#e5c76b] rounded-full mb-4 shadow-lg shadow-[#d4af37]/30">
            <i class="fas fa-key text-white text-xl"></i>
        </div>
        <h2 class="text-2xl font-bold text-gray-900" style="font-family: 'Playfair Display', serif;">
            Reset Password
        </h2>
        <p class="text-sm text-gray-500 mt-2">Enter your new password below</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                <i class="fas fa-envelope text-[#d4af37] mr-1"></i>
                {{ __('Email') }}
            </label>
            <x-text-input id="email" class="block w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                <i class="fas fa-lock text-[#d4af37] mr-1"></i>
                {{ __('New Password') }}
            </label>
            <x-text-input id="password" class="block w-full" type="password" name="password" required
                autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation"
                class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                <i class="fas fa-lock text-[#d4af37] mr-1"></i>
                {{ __('Confirm Password') }}
            </label>
            <x-text-input id="password_confirmation" class="block w-full" type="password" name="password_confirmation"
                required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Submit Button -->
        <button type="submit"
            class="w-full bg-gradient-to-r from-[#1a1a1a] to-[#333] text-white py-4 rounded-xl font-bold uppercase tracking-widest text-sm hover:from-[#d4af37] hover:to-[#b5952f] transition-all duration-300 shadow-lg hover:shadow-[#d4af37]/30 flex items-center justify-center gap-2 group">
            <i class="fas fa-check-circle"></i>
            <span>{{ __('Reset Password') }}</span>
        </button>
    </form>
</x-guest-layout>