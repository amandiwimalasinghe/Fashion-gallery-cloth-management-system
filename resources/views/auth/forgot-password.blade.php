<x-guest-layout>
    <!-- Header -->
    <div class="mb-6 text-center">
        <div
            class="inline-flex items-center justify-center w-14 h-14 bg-gradient-to-br from-[#d4af37] to-[#e5c76b] rounded-full mb-4 shadow-lg shadow-[#d4af37]/30">
            <i class="fas fa-unlock-alt text-white text-xl"></i>
        </div>
        <h2 class="text-2xl font-bold text-gray-900" style="font-family: 'Playfair Display', serif;">
            Forgot Password?
        </h2>
    </div>

    <div class="mb-6 text-sm text-gray-500 text-center leading-relaxed">
        No worries! Just enter your email address and we'll send you a password reset link.
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                <i class="fas fa-envelope text-[#d4af37] mr-1"></i>
                {{ __('Email Address') }}
            </label>
            <x-text-input id="email" class="block w-full" type="email" name="email" :value="old('email')" required
                autofocus placeholder="your@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Submit Button -->
        <button type="submit"
            class="w-full bg-gradient-to-r from-[#1a1a1a] to-[#333] text-white py-4 rounded-xl font-bold uppercase tracking-widest text-sm hover:from-[#d4af37] hover:to-[#b5952f] transition-all duration-300 shadow-lg hover:shadow-[#d4af37]/30 flex items-center justify-center gap-2 group">
            <i class="fas fa-paper-plane"></i>
            <span>{{ __('Send Reset Link') }}</span>
        </button>

        <!-- Back to Login -->
        <p class="text-center text-gray-500 text-sm mt-4">
            <a href="{{ route('login') }}"
                class="text-[#d4af37] hover:text-[#b5952f] font-semibold transition-colors inline-flex items-center gap-1">
                <i class="fas fa-arrow-left text-xs"></i>
                Back to Login
            </a>
        </p>
    </form>
</x-guest-layout>