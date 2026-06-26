<section>
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        @if($user->role === 'designer')
            <!-- Profile Image for Designers -->
            <div
                class="flex items-center gap-6 p-5 bg-gradient-to-r from-gray-50 to-white rounded-xl border border-gray-100">
                <div class="shrink-0 relative">
                    @if($user->profile_image)
                        <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Profile"
                            class="h-24 w-24 object-cover rounded-xl border-4 border-[#d4af37]/20 shadow-md">
                    @else
                        <div class="h-24 w-24 rounded-xl bg-gradient-to-br from-[#d4af37] to-[#b5952f] flex items-center justify-center text-white text-3xl font-bold"
                            style="font-family: 'Playfair Display', serif;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                    <div
                        class="absolute -bottom-2 -right-2 w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center text-white shadow-md border-2 border-white">
                        <i class="fas fa-camera text-xs"></i>
                    </div>
                </div>
                <div class="flex-1">
                    <label for="profile_image"
                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                        <i class="fas fa-image text-[#d4af37] mr-1"></i> Update Profile Image
                    </label>
                    <input id="profile_image" name="profile_image" type="file"
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[#d4af37] file:text-white hover:file:bg-[#b5952f] cursor-pointer" />
                    <p class="text-xs text-gray-400 mt-1">PNG, JPG or JPEG up to 5MB</p>
                    <x-input-error class="mt-2" :messages="$errors->get('profile_image')" />
                </div>
            </div>
        @endif

        <!-- Basic Info Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label for="name" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                    <i class="fas fa-user text-[#d4af37] mr-1"></i> Full Name *
                </label>
                <x-text-input id="name" name="name" type="text" class="block w-full" :value="old('name', $user->name)"
                    required autofocus autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <div>
                <label for="email" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                    <i class="fas fa-envelope text-[#d4af37] mr-1"></i> Email Address *
                </label>
                <x-text-input id="email" name="email" type="email" class="block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                    <div class="mt-2">
                        <p class="text-sm text-amber-600 flex items-center gap-2">
                            <i class="fas fa-exclamation-triangle"></i>
                            Your email is unverified.
                            <button form="send-verification"
                                class="text-[#d4af37] underline hover:text-[#b5952f] font-semibold">
                                Resend verification
                            </button>
                        </p>
                    </div>
                @endif
            </div>

            <div>
                <label for="phone" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                    <i class="fas fa-phone text-[#d4af37] mr-1"></i> Phone Number *
                </label>
                <x-text-input id="phone" name="phone" type="text" class="block w-full" :value="old('phone', $user->phone)" required />
                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
            </div>
        </div>

        <!-- Address -->
        <div>
            <label for="address" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                <i class="fas fa-map-marker-alt text-[#d4af37] mr-1"></i> Shipping Address *
            </label>
            <textarea id="address" name="address" rows="3"
                class="block w-full border-2 border-gray-200 rounded-xl py-3 px-4 focus:border-[#d4af37] focus:ring-[#d4af37] transition-all"
                required>{{ old('address', $user->address) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('address')" />
        </div>

        <!-- Company Details -->
        <details class="group border border-gray-100 rounded-xl overflow-hidden">
            <summary
                class="flex items-center justify-between cursor-pointer text-sm font-bold text-gray-500 uppercase tracking-wider p-4 bg-gray-50 hover:bg-gray-100 transition-colors">
                <span><i class="fas fa-building text-[#d4af37] mr-2"></i>Company Details (Optional)</span>
                <i class="fas fa-chevron-down text-gray-400 group-open:rotate-180 transition-transform"></i>
            </summary>
            <div class="p-4 grid grid-cols-1 md:grid-cols-2 gap-4 bg-white">
                <div>
                    <label for="company_name"
                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                        Company Name
                    </label>
                    <x-text-input id="company_name" name="company_name" type="text" class="block w-full"
                        :value="old('company_name', $user->company_name)" />
                    <x-input-error class="mt-2" :messages="$errors->get('company_name')" />
                </div>

                <div>
                    <label for="company_email"
                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                        Company Email
                    </label>
                    <x-text-input id="company_email" name="company_email" type="email" class="block w-full"
                        :value="old('company_email', $user->company_email)" />
                    <x-input-error class="mt-2" :messages="$errors->get('company_email')" />
                </div>

                <div class="md:col-span-2">
                    <label for="company_phone"
                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                        Company Phone
                    </label>
                    <x-text-input id="company_phone" name="company_phone" type="text" class="block w-full"
                        :value="old('company_phone', $user->company_phone)" />
                    <x-input-error class="mt-2" :messages="$errors->get('company_phone')" />
                </div>
            </div>
        </details>

        <!-- Save Button -->
        <div class="flex items-center gap-4 pt-4">
            <button type="submit"
                class="inline-flex items-center gap-2 bg-gradient-to-r from-[#1a1a1a] to-[#333] text-white px-8 py-3 rounded-xl font-bold uppercase text-sm tracking-widest hover:from-[#d4af37] hover:to-[#b5952f] transition-all duration-300 shadow-lg hover:shadow-[#d4af37]/30">
                <i class="fas fa-save"></i>
                {{ __('Save Changes') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                    class="text-sm text-green-600 font-medium flex items-center gap-1">
                    <i class="fas fa-check-circle"></i>
                    {{ __('Saved successfully!') }}
                </p>
            @endif
        </div>
    </form>
</section>