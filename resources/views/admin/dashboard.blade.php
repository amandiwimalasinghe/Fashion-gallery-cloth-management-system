<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div
                class="w-12 h-12 bg-gradient-to-br from-[#1a1a1a] to-[#333] rounded-xl flex items-center justify-center shadow-lg">
                <i class="fas fa-user-shield text-[#d4af37] text-lg"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-900" style="font-family: 'Playfair Display', serif;">
                    {{ __('Admin Panel') }}
                </h2>
                <p class="text-sm text-gray-500">Manage Fashion Gallery administration tools</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-b from-gray-50 to-white min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                <!-- User Management Card -->
                <div
                    class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col justify-between hover:shadow-lg transition-all duration-300">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <div
                                class="w-14 h-14 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center shadow-md shadow-red-500/20">
                                <i class="fas fa-users-cog text-white text-xl"></i>
                            </div>
                            <span
                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-600">
                                <i class="fas fa-users text-[#d4af37]"></i>
                                {{ $totalUsers }} Users
                            </span>
                        </div>

                        <h3 class="text-xl font-bold text-gray-900 mb-2" style="font-family: 'Playfair Display', serif;">
                            User Management
                        </h3>
                        <p class="text-sm text-gray-500 mb-6">
                            View all registered users, update user roles, edit details, or remove accounts.
                        </p>
                    </div>

                    <a href="{{ route('admin.users') }}"
                        class="w-full inline-flex items-center justify-center gap-2 bg-gradient-to-r from-[#1a1a1a] to-[#333] text-white px-6 py-3 rounded-xl font-bold uppercase text-xs tracking-widest hover:from-[#d4af37] hover:to-[#b5952f] transition-all duration-300 shadow-md hover:shadow-[#d4af37]/30">
                        <i class="fas fa-users-cog"></i>
                        <span>User Management</span>
                        <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>

                <!-- Order Management Card -->
                <div
                    class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col justify-between hover:shadow-lg transition-all duration-300">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <div
                                class="w-14 h-14 bg-gradient-to-br from-[#d4af37] to-[#b5952f] rounded-xl flex items-center justify-center shadow-md shadow-[#d4af37]/20">
                                <i class="fas fa-box-open text-white text-xl"></i>
                            </div>
                            <span
                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-600">
                                <i class="fas fa-shopping-bag text-[#d4af37]"></i>
                                {{ $totalOrders }} Orders
                            </span>
                        </div>

                        <h3 class="text-xl font-bold text-gray-900 mb-2" style="font-family: 'Playfair Display', serif;">
                            Order Management
                        </h3>
                        <p class="text-sm text-gray-500 mb-6">
                            View all customer orders, ordered items, payment methods, totals, and order statuses.
                        </p>
                    </div>

                    <a href="{{ route('admin.orders') }}"
                        class="w-full inline-flex items-center justify-center gap-2 bg-gradient-to-r from-[#1a1a1a] to-[#333] text-white px-6 py-3 rounded-xl font-bold uppercase text-xs tracking-widest hover:from-[#d4af37] hover:to-[#b5952f] transition-all duration-300 shadow-md hover:shadow-[#d4af37]/30">
                        <i class="fas fa-box-open"></i>
                        <span>Order Management</span>
                        <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
