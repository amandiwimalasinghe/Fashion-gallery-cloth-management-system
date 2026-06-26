<x-guest-layout>
    <!-- Header -->
    <div class="mb-6 text-center">
        <div
            class="inline-flex items-center justify-center w-14 h-14 bg-gradient-to-br from-[#d4af37] to-[#e5c76b] rounded-full mb-4 shadow-lg shadow-[#d4af37]/30">
            <i class="fas fa-user-plus text-white text-xl"></i>
        </div>
        <h2 class="text-2xl font-bold text-gray-900" style="font-family: 'Playfair Display', serif;">
            Create Account
        </h2>
        <p class="text-xs text-gray-500 mt-1">Join our exclusive fashion community today.</p>
    </div>

    @if ($errors->any())
        <div class="mb-4 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl relative text-xs animate-shake"
            role="alert">
            <strong class="font-bold"><i class="fas fa-exclamation-circle mr-1"></i>Whoops!</strong>
            <span class="block sm:inline">Please fix the following errors:</span>
            <ul class="mt-2 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" id="registerForm"
        class="space-y-4">
        @csrf

        <!-- Role Selection -->
        <div class="mb-4">
            <label for="role" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                <i class="fas fa-user-tag text-[#d4af37] mr-1"></i>I am a:
            </label>
            <div class="grid grid-cols-2 gap-3">
                <label class="relative cursor-pointer">
                    <input type="radio" name="role" value="customer" class="sr-only peer" {{ old('role', 'customer') == 'customer' ? 'checked' : '' }} onchange="toggleDesignerFields()">
                    <div
                        class="p-3 border-2 border-gray-200 rounded-xl text-center peer-checked:border-[#d4af37] peer-checked:bg-[#d4af37]/5 transition-all duration-300 hover:border-gray-300">
                        <i class="fas fa-shopping-bag text-xl mb-1 text-gray-400 peer-checked:text-[#d4af37]"></i>
                        <p class="text-sm font-semibold text-gray-700">Customer</p>
                        <p class="text-[10px] text-gray-400">Shop designs</p>
                    </div>
                </label>
                <label class="relative cursor-pointer">
                    <input type="radio" name="role" value="designer" class="sr-only peer" {{ old('role') == 'designer' ? 'checked' : '' }} onchange="toggleDesignerFields()">
                    <div
                        class="p-3 border-2 border-gray-200 rounded-xl text-center peer-checked:border-[#d4af37] peer-checked:bg-[#d4af37]/5 transition-all duration-300 hover:border-gray-300">
                        <i class="fas fa-palette text-xl mb-1 text-gray-400 peer-checked:text-[#d4af37]"></i>
                        <p class="text-sm font-semibold text-gray-700">Designer</p>
                        <p class="text-[10px] text-gray-400">Sell designs</p>
                    </div>
                </label>
            </div>
            <x-input-error :messages="$errors->get('role')" class="mt-1 text-[10px]" />
        </div>

        <!-- Basic Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-input-label for="name" :value="__('Full Name')" class="text-xs flex items-center gap-1 mb-1">
                    <i class="fas fa-user text-[#d4af37] text-[10px]"></i>
                </x-input-label>
                <x-text-input id="name"
                    class="block w-full py-2.5 text-sm border-2 border-gray-200 rounded-xl focus:border-[#d4af37] focus:ring-[#d4af37] {{ $errors->has('name') ? 'border-red-400' : '' }}"
                    type="text" name="name" :value="old('name')" required autofocus placeholder="John Doe" />
                <x-input-error :messages="$errors->get('name')" class="mt-1 text-[10px]" />
            </div>

            <div>
                <x-input-label for="email" :value="__('Email Address')" class="text-xs flex items-center gap-1 mb-1">
                    <i class="fas fa-envelope text-[#d4af37] text-[10px]"></i>
                </x-input-label>
                <x-text-input id="email"
                    class="block w-full py-2.5 text-sm border-2 border-gray-200 rounded-xl focus:border-[#d4af37] focus:ring-[#d4af37] {{ $errors->has('email') ? 'border-red-400' : '' }}"
                    type="email" name="email" :value="old('email')" required placeholder="john@example.com" />
                <x-input-error :messages="$errors->get('email')" class="mt-1 text-[10px]" />
            </div>

            <div>
                <x-input-label for="phone" :value="__('Phone Number')" class="text-xs flex items-center gap-1 mb-1">
                    <i class="fas fa-phone text-[#d4af37] text-[10px]"></i>
                </x-input-label>
                <x-text-input id="phone"
                    class="block w-full py-2.5 text-sm border-2 border-gray-200 rounded-xl focus:border-[#d4af37] focus:ring-[#d4af37] {{ $errors->has('phone') ? 'border-red-400' : '' }}"
                    type="text" name="phone" :value="old('phone')" required placeholder="+94 77 123 4567" />
                <x-input-error :messages="$errors->get('phone')" class="mt-1 text-[10px]" />
            </div>

            <!-- Designer Profile Image -->
            <div id="designerImageField" style="display: none;">
                <x-input-label for="profile_image" :value="__('Profile Image')"
                    class="text-xs flex items-center gap-1 mb-1">
                    <i class="fas fa-camera text-[#d4af37] text-[10px]"></i>
                </x-input-label>
                <input id="profile_image"
                    class="block w-full text-xs text-gray-900 border-2 border-gray-200 rounded-xl cursor-pointer bg-gray-50 focus:outline-none p-2 file:mr-3 file:py-1.5 file:px-3 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-[#d4af37] file:text-white hover:file:bg-[#b5952f] {{ $errors->has('profile_image') ? 'border-red-400' : '' }}"
                    type="file" name="profile_image" accept="image/png, image/jpeg, image/jpg">
                <x-input-error :messages="$errors->get('profile_image')" class="mt-1 text-[10px]" />
            </div>
        </div>

        <!-- Address -->
        <div>
            <x-input-label for="address" :value="__('Shipping Address')" class="text-xs flex items-center gap-1 mb-1">
                <i class="fas fa-map-marker-alt text-[#d4af37] text-[10px]"></i>
            </x-input-label>
            <textarea id="address" name="address"
                class="block w-full border-2 border-gray-200 rounded-xl text-sm focus:border-[#d4af37] focus:ring-[#d4af37] p-3 {{ $errors->has('address') ? 'border-red-400' : '' }}"
                required rows="2" placeholder="123 Main Street, Colombo">{{ old('address') }}</textarea>
            <x-input-error :messages="$errors->get('address')" class="mt-1 text-[10px]" />
        </div>

        <!-- Company Details (Collapsible) -->
        <details class="group">
            <summary
                class="flex items-center justify-between cursor-pointer text-xs font-semibold text-gray-500 uppercase tracking-wider py-2 border-t border-gray-100">
                <span><i class="fas fa-building text-[#d4af37] mr-1"></i>Company Details (Optional)</span>
                <i class="fas fa-chevron-down text-gray-400 group-open:rotate-180 transition-transform"></i>
            </summary>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 pt-3">
                <x-text-input id="company_name" placeholder="Company Name"
                    class="block w-full py-2 text-sm border-2 border-gray-200 rounded-xl focus:border-[#d4af37] focus:ring-[#d4af37]"
                    type="text" name="company_name" :value="old('company_name')" />
                <x-text-input id="company_email" placeholder="Company Email"
                    class="block w-full py-2 text-sm border-2 border-gray-200 rounded-xl focus:border-[#d4af37] focus:ring-[#d4af37]"
                    type="email" name="company_email" :value="old('company_email')" />
                <x-text-input id="company_phone" placeholder="Company Phone"
                    class="block w-full py-2 text-sm border-2 border-gray-200 rounded-xl focus:border-[#d4af37] focus:ring-[#d4af37] md:col-span-2"
                    type="text" name="company_phone" :value="old('company_phone')" />
            </div>
        </details>

        <!-- Security Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-3 border-t border-gray-100">
            <div>
                <x-input-label for="password" :value="__('Password')" class="text-xs flex items-center gap-1 mb-1">
                    <i class="fas fa-lock text-[#d4af37] text-[10px]"></i>
                </x-input-label>
                <x-text-input id="password"
                    class="block w-full py-2.5 text-sm border-2 border-gray-200 rounded-xl focus:border-[#d4af37] focus:ring-[#d4af37] {{ $errors->has('password') ? 'border-red-400' : '' }}"
                    type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
                <x-input-error :messages="$errors->get('password')" class="mt-1 text-[10px]" />
            </div>

            <div>
                <x-input-label for="password_confirmation" :value="__('Confirm Password')"
                    class="text-xs flex items-center gap-1 mb-1">
                    <i class="fas fa-lock text-[#d4af37] text-[10px]"></i>
                </x-input-label>
                <x-text-input id="password_confirmation"
                    class="block w-full py-2.5 text-sm border-2 border-gray-200 rounded-xl focus:border-[#d4af37] focus:ring-[#d4af37]"
                    type="password" name="password_confirmation" required autocomplete="new-password"
                    placeholder="••••••••" />
            </div>
        </div>

        <!-- Submit -->
        <div class="flex items-center justify-between pt-4">
            <a class="text-xs text-gray-600 hover:text-[#d4af37] transition-colors" href="{{ route('login') }}">
                <i class="fas fa-arrow-left mr-1"></i>Already registered?
            </a>

            <button type="submit"
                class="bg-gradient-to-r from-[#1a1a1a] to-[#333] text-white px-8 py-3 rounded-xl font-bold uppercase tracking-widest text-xs hover:from-[#d4af37] hover:to-[#b5952f] transition-all duration-300 shadow-lg hover:shadow-[#d4af37]/30 flex items-center gap-2 group">
                <span>{{ __('Create Account') }}</span>
                <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
            </button>
        </div>
    </form>

    <script>
        function toggleDesignerFields() {
            const designerRadio = document.querySelector('input[name="role"][value="designer"]');
            const designerImageField = document.getElementById('designerImageField');

            if (designerRadio && designerRadio.checked) {
                designerImageField.style.display = 'block';
            } else {
                designerImageField.style.display = 'none';
                document.getElementById('profile_image').value = '';
            }
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', toggleDesignerFields);
    </script>

    <style>
        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            10%,
            30%,
            50%,
            70%,
            90% {
                transform: translateX(-4px);
            }

            20%,
            40%,
            60%,
            80% {
                transform: translateX(4px);
            }
        }

        .animate-shake {
            animation: shake 0.5s ease-in-out;
        }
    </style>
</x-guest-layout>