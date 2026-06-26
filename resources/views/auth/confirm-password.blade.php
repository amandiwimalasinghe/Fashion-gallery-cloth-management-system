<x-guest-layout>
    <!-- Header -->
    <div class="mb-6 text-center">
        <div
            class="inline-flex items-center justify-center w-14 h-14 bg-gradient-to-br from-[#d4af37] to-[#e5c76b] rounded-full mb-4 shadow-lg shadow-[#d4af37]/30">
            <i class="fas fa-shield-alt text-white text-xl"></i>
        </div>
        <h2 class="text-2xl font-bold text-gray-900" style="font-family: 'Playfair Display', serif;">
            Secure Area
        </h2>
    </div>

    <div class="mb-6 text-sm text-gray-500 text-center leading-relaxed">
        This is a secure area. Please confirm your password before continuing.
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
        @csrf

        <!-- Password -->
        <div>
            <label for="password" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                <i class="fas fa-lock text-[#d4af37] mr-1"></i>
                {{ __('Password') }}
            </label>
            <x-text-input id="password" class="block w-full" type="password" name="password" required
                autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Submit Button -->
        <button type="submit"
            class="w-full bg-gradient-to-r from-[#1a1a1a] to-[#333] text-white py-4 rounded-xl font-bold uppercase tracking-widest text-sm hover:from-[#d4af37] hover:to-[#b5952f] transition-all duration-300 shadow-lg hover:shadow-[#d4af37]/30 flex items-center justify-center gap-2">
            <i class="fas fa-check"></i>
            <span>{{ __('Confirm') }}</span>
        </button>
    </form>
</x-guest-layout>