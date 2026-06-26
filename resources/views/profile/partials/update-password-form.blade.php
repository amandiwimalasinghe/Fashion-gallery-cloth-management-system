<section>
    <form method="post" action="{{ route('password.update') }}" class="space-y-5">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password"
                class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                <i class="fas fa-lock text-[#d4af37] mr-1"></i> Current Password
            </label>
            <x-text-input id="update_password_current_password" name="current_password" type="password"
                class="block w-full" autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <label for="update_password_password"
                class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                <i class="fas fa-key text-[#d4af37] mr-1"></i> New Password
            </label>
            <x-text-input id="update_password_password" name="password" type="password" class="block w-full"
                autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <label for="update_password_password_confirmation"
                class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                <i class="fas fa-check-double text-[#d4af37] mr-1"></i> Confirm Password
            </label>
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password"
                class="block w-full" autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit"
                class="inline-flex items-center gap-2 bg-gradient-to-r from-[#1a1a1a] to-[#333] text-white px-8 py-3 rounded-xl font-bold uppercase text-sm tracking-widest hover:from-[#d4af37] hover:to-[#b5952f] transition-all duration-300 shadow-lg hover:shadow-[#d4af37]/30">
                <i class="fas fa-shield-alt"></i>
                {{ __('Update Password') }}
            </button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                    class="text-sm text-green-600 font-medium flex items-center gap-1">
                    <i class="fas fa-check-circle"></i>
                    {{ __('Password updated!') }}
                </p>
            @endif
        </div>
    </form>
</section>