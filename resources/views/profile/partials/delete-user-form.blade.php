<section class="space-y-6">
    <div class="p-4 bg-red-50 rounded-xl border border-red-100">
        <p class="text-sm text-red-600 leading-relaxed">
            <i class="fas fa-exclamation-triangle mr-1"></i>
            Once your account is deleted, all of its resources and data will be permanently removed. This action cannot
            be undone.
        </p>
    </div>

    <x-danger-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 px-6 py-3 rounded-xl font-bold uppercase text-sm tracking-widest transition-all duration-300 shadow-lg hover:shadow-red-500/30">
        <i class="fas fa-trash-alt"></i>
        {{ __('Delete Account') }}
    </x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-8">
            @csrf
            @method('delete')

            <!-- Modal Header -->
            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-exclamation-triangle text-red-600 text-2xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-900" style="font-family: 'Playfair Display', serif;">
                    {{ __('Delete Account?') }}
                </h2>
                <p class="mt-3 text-sm text-gray-500 max-w-md mx-auto">
                    This will permanently delete your account and all associated data including orders, reviews, and
                    designs.
                </p>
            </div>

            <!-- Password Confirmation -->
            <div class="mb-6">
                <label for="password" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                    <i class="fas fa-lock text-red-500 mr-1"></i> Confirm Your Password
                </label>
                <x-text-input id="password" name="password" type="password"
                    class="block w-full border-red-200 focus:border-red-400 focus:ring-red-400"
                    placeholder="Enter your password to confirm" />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')"
                    class="px-6 py-3 border-2 border-gray-200 text-gray-600 rounded-xl font-semibold hover:bg-gray-50 transition-colors">
                    {{ __('Cancel') }}
                </button>

                <button type="submit"
                    class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl font-bold uppercase text-sm tracking-widest transition-all duration-300 shadow-lg hover:shadow-red-500/30">
                    <i class="fas fa-trash-alt"></i>
                    {{ __('Delete Forever') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>