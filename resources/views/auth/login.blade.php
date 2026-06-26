<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Header -->
    <div class="mb-8 text-center">
        <div
            class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-[#d4af37] to-[#e5c76b] rounded-full mb-4 shadow-lg shadow-[#d4af37]/30">
            <i class="fas fa-door-open text-white text-2xl"></i>
        </div>
        <h2 class="text-2xl font-bold text-gray-900" style="font-family: 'Playfair Display', serif;">
            Welcome Back
        </h2>
        <p class="text-sm text-gray-500 mt-2">Sign in to access your account and explore premium designs.</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email -->
        <div>
            <label for="email" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                <i class="fas fa-envelope text-[#d4af37] mr-1"></i>
                {{ __('Email Address') }}
            </label>
            <div class="relative">
                <x-text-input id="email"
                    class="block w-full pl-4 pr-10 py-3.5 border-2 border-gray-200 rounded-xl focus:border-[#d4af37] focus:ring-[#d4af37] transition-all duration-300"
                    type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                    placeholder="your@email.com" />
                <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-300">
                    <i class="fas fa-at"></i>
                </span>
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                <i class="fas fa-lock text-[#d4af37] mr-1"></i>
                {{ __('Password') }}
            </label>
            <div class="relative">
                <x-text-input id="password"
                    class="block w-full pl-4 pr-10 py-3.5 border-2 border-gray-200 rounded-xl focus:border-[#d4af37] focus:ring-[#d4af37] transition-all duration-300"
                    type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
                <button type="button" onclick="togglePassword()"
                    class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-300 hover:text-[#d4af37] transition-colors">
                    <i class="fas fa-eye" id="toggleIcon"></i>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember & Forgot -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                <input id="remember_me" type="checkbox"
                    class="w-5 h-5 rounded border-gray-300 text-[#d4af37] shadow-sm focus:ring-[#d4af37] focus:ring-offset-0 cursor-pointer"
                    name="remember">
                <span
                    class="ms-2 text-sm text-gray-600 group-hover:text-gray-900 transition-colors">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-gray-500 hover:text-[#d4af37] transition-colors font-medium"
                    href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <button type="submit"
            class="w-full bg-gradient-to-r from-[#1a1a1a] to-[#333] text-white py-4 rounded-xl font-bold uppercase tracking-widest text-sm hover:from-[#d4af37] hover:to-[#b5952f] transition-all duration-300 shadow-lg hover:shadow-[#d4af37]/30 flex items-center justify-center gap-2 group">
            <span>{{ __('Sign In') }}</span>
            <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
        </button>

        <!-- Divider -->
        <div class="relative my-6">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-200"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-4 bg-white text-gray-400">or</span>
            </div>
        </div>

        <!-- Register Link -->
        <p class="text-center text-gray-500 text-sm">
            Don't have an account?
            <a href="{{ route('register') }}"
                class="text-[#d4af37] hover:text-[#b5952f] font-semibold transition-colors">
                Create one now
            </a>
        </p>
    </form>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.getElementById('toggleIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</x-guest-layout>