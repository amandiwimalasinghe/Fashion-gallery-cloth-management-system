<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div
                class="w-12 h-12 bg-gradient-to-br from-[#d4af37] to-[#e5c76b] rounded-xl flex items-center justify-center shadow-lg shadow-[#d4af37]/20">
                <i class="fas fa-user-cog text-white text-lg"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-900" style="font-family: 'Playfair Display', serif;">
                    {{ __('Account Settings') }}
                </h2>
                <p class="text-sm text-gray-500">Manage your profile and security settings</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-b from-gray-50 to-white min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Profile Quick View Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
                <div class="flex flex-col sm:flex-row items-center gap-6">
                    <div class="relative">
                        <div
                            class="w-24 h-24 rounded-2xl overflow-hidden border-4 border-[#d4af37]/20 shadow-lg bg-gray-100">
                            @if($user->profile_image)
                                <img src="{{ asset('storage/' . $user->profile_image) }}"
                                    class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-[#d4af37] to-[#b5952f] flex items-center justify-center text-white text-3xl font-bold"
                                    style="font-family: 'Playfair Display', serif;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <div
                            class="absolute -bottom-2 -right-2 w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center shadow-md border-2 border-white">
                            <i class="fas fa-check text-white text-xs"></i>
                        </div>
                    </div>
                    <div class="text-center sm:text-left flex-1">
                        <h3 class="text-2xl font-bold text-gray-900" style="font-family: 'Playfair Display', serif;">
                            {{ $user->name }}</h3>
                        <p class="text-gray-500">{{ $user->email }}</p>
                        <div class="flex flex-wrap items-center justify-center sm:justify-start gap-3 mt-3">
                            <span
                                class="inline-flex items-center gap-1 bg-gradient-to-r from-[#d4af37] to-[#e5c76b] text-white text-xs font-bold px-3 py-1 rounded-full">
                                <i class="fas fa-{{ $user->role === 'designer' ? 'palette' : 'shopping-bag' }}"></i>
                                {{ ucfirst($user->role) }}
                            </span>
                            <span class="text-xs text-gray-400">Member since
                                {{ $user->created_at->format('M Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Settings Sections -->
            <div class="space-y-8">
                <!-- Profile Information -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div
                        class="bg-gradient-to-r from-gray-50 to-white px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-user text-blue-600"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900">Profile Information</h3>
                            <p class="text-xs text-gray-500">Update your account's profile information and email
                                address.</p>
                        </div>
                    </div>
                    <div class="p-6">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <!-- Update Password -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div
                        class="bg-gradient-to-r from-gray-50 to-white px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                        <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-lock text-green-600"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900">Update Password</h3>
                            <p class="text-xs text-gray-500">Ensure your account is using a long, random password to
                                stay secure.</p>
                        </div>
                    </div>
                    <div class="p-6">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <!-- Delete Account -->
                <div class="bg-white rounded-2xl shadow-sm border border-red-100 overflow-hidden">
                    <div
                        class="bg-gradient-to-r from-red-50 to-white px-6 py-4 border-b border-red-100 flex items-center gap-3">
                        <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-trash-alt text-red-600"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-red-600">Delete Account</h3>
                            <p class="text-xs text-gray-500">Permanently delete your account and all associated data.
                            </p>
                        </div>
                    </div>
                    <div class="p-6">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>