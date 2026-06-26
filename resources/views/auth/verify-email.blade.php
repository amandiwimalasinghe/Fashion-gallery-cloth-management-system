<x-guest-layout>
    <!-- Header -->
    <div class="mb-6 text-center">
        <div
            class="inline-flex items-center justify-center w-14 h-14 bg-gradient-to-br from-[#d4af37] to-[#e5c76b] rounded-full mb-4 shadow-lg shadow-[#d4af37]/30">
            <i class="fas fa-envelope-open-text text-white text-xl"></i>
        </div>
        <h2 class="text-2xl font-bold text-gray-900" style="font-family: 'Playfair Display', serif;">
            Verify Email
        </h2>
    </div>

    <div class="mb-6 text-sm text-gray-500 text-center leading-relaxed">
        Thanks for signing up! Before getting started, please verify your email address by clicking on the link we just
        sent you.
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm flex items-center gap-2">
            <i class="fas fa-check-circle"></i>
            A new verification link has been sent to your email address.
        </div>
    @endif

    <div class="flex flex-col gap-4">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit"
                class="w-full bg-gradient-to-r from-[#1a1a1a] to-[#333] text-white py-4 rounded-xl font-bold uppercase tracking-widest text-sm hover:from-[#d4af37] hover:to-[#b5952f] transition-all duration-300 shadow-lg hover:shadow-[#d4af37]/30 flex items-center justify-center gap-2">
                <i class="fas fa-redo"></i>
                <span>{{ __('Resend Verification Email') }}</span>
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="w-full py-3 text-gray-500 hover:text-[#d4af37] rounded-xl font-medium text-sm transition-colors flex items-center justify-center gap-2">
                <i class="fas fa-sign-out-alt"></i>
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>