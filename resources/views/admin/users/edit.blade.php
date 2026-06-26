<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div
                class="w-12 h-12 bg-gradient-to-br from-amber-400 to-amber-500 rounded-xl flex items-center justify-center shadow-lg shadow-amber-500/20">
                <i class="fas fa-user-edit text-white text-lg"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-900" style="font-family: 'Playfair Display', serif;">
                    {{ __('Edit User') }}
                </h2>
                <p class="text-sm text-gray-500">Modify user details for: {{ $user->name }}</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-b from-gray-50 to-white min-h-screen">
        <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

                <!-- User Header -->
                <div
                    class="bg-gradient-to-r from-gray-50 to-white px-8 py-6 border-b border-gray-100 flex items-center gap-4">
                    <div class="w-16 h-16 rounded-xl bg-gradient-to-br from-[#d4af37] to-[#b5952f] flex items-center justify-center text-white text-2xl font-bold shadow-md"
                        style="font-family: 'Playfair Display', serif;">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">{{ $user->name }}</h3>
                        <p class="text-sm text-gray-500">User ID: #{{ $user->id }}</p>
                    </div>
                </div>

                <div class="p-8">
                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Name -->
                        <div>
                            <label for="name"
                                class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                <i class="fas fa-user text-[#d4af37] mr-1"></i> Full Name
                            </label>
                            <x-text-input id="name" type="text" name="name" :value="$user->name" class="block w-full"
                                required />
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email"
                                class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                <i class="fas fa-envelope text-[#d4af37] mr-1"></i> Email Address
                            </label>
                            <x-text-input id="email" type="email" name="email" :value="$user->email"
                                class="block w-full" required />
                        </div>

                        <!-- Role -->
                        <div>
                            <label for="role"
                                class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                <i class="fas fa-user-tag text-[#d4af37] mr-1"></i> User Role
                            </label>
                            <select id="role" name="role"
                                class="block w-full border-2 border-gray-200 rounded-xl py-3 px-4 focus:border-[#d4af37] focus:ring-[#d4af37] bg-white cursor-pointer">
                                <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>👤 User (Customer)
                                </option>
                                <option value="designer" {{ $user->role == 'designer' ? 'selected' : '' }}>🎨 Designer
                                </option>
                                <option value="tailor" {{ $user->role == 'tailor' ? 'selected' : '' }}>✂️ Tailor</option>
                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>🛡️ Admin</option>
                            </select>
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password"
                                class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                <i class="fas fa-lock text-[#d4af37] mr-1"></i> New Password (Optional)
                            </label>
                            <x-text-input id="password" type="password" name="password" class="block w-full"
                                placeholder="Leave blank to keep current password" />
                            <p class="text-xs text-gray-400 mt-1">Only fill this if you want to change the password</p>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                            <a href="{{ route('admin.users.index') }}"
                                class="inline-flex items-center gap-2 px-6 py-3 border-2 border-gray-200 text-gray-600 rounded-xl font-semibold hover:bg-gray-50 transition-colors">
                                <i class="fas fa-arrow-left"></i>
                                Cancel
                            </a>
                            <button type="submit"
                                class="inline-flex items-center gap-2 bg-gradient-to-r from-[#1a1a1a] to-[#333] text-white px-8 py-3 rounded-xl font-bold uppercase text-sm tracking-widest hover:from-[#d4af37] hover:to-[#b5952f] transition-all duration-300 shadow-lg hover:shadow-[#d4af37]/30">
                                <i class="fas fa-save"></i>
                                Update User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>