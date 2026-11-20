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

            <!-- Reports Section -->
            <div class="mt-12">
                <div class="flex items-center gap-3 mb-6">
                    <div
                        class="w-10 h-10 bg-gradient-to-br from-[#d4af37] to-[#b5952f] rounded-xl flex items-center justify-center shadow-md shadow-[#d4af37]/20">
                        <i class="fas fa-chart-line text-white text-base"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900" style="font-family: 'Playfair Display', serif;">
                            Reports
                        </h3>
                        <p class="text-sm text-gray-500">View detailed analytics and business reports</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Sales & Revenue Report -->
                    <div
                        class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col justify-between hover:shadow-lg transition-all duration-300">
                        <div>
                            <div
                                class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-md shadow-emerald-500/20 mb-4">
                                <i class="fas fa-coins text-white text-lg"></i>
                            </div>
                            <h4 class="text-lg font-bold text-gray-900 mb-2" style="font-family: 'Playfair Display', serif;">
                                Sales & Revenue Report
                            </h4>
                            <p class="text-sm text-gray-500 mb-6">
                                Track total revenue, monthly sales trends, payment methods, order statuses, and top-selling items.
                            </p>
                        </div>
                        <a href="{{ route('admin.reports.sales') }}"
                            class="w-full inline-flex items-center justify-center gap-2 bg-gradient-to-r from-[#1a1a1a] to-[#333] text-white px-5 py-3 rounded-xl font-bold uppercase text-xs tracking-widest hover:from-[#d4af37] hover:to-[#b5952f] transition-all duration-300 shadow-md hover:shadow-[#d4af37]/30">
                            <i class="fas fa-chart-bar"></i>
                            <span>View Report</span>
                            <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>

                    <!-- Designer Performance Report -->
                    <div
                        class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col justify-between hover:shadow-lg transition-all duration-300">
                        <div>
                            <div
                                class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center shadow-md shadow-purple-500/20 mb-4">
                                <i class="fas fa-palette text-white text-lg"></i>
                            </div>
                            <h4 class="text-lg font-bold text-gray-900 mb-2" style="font-family: 'Playfair Display', serif;">
                                Designer Performance Report
                            </h4>
                            <p class="text-sm text-gray-500 mb-6">
                                Compare designer sales, items sold, product counts, customer reviews, and average ratings.
                            </p>
                        </div>
                        <a href="{{ route('admin.reports.designers') }}"
                            class="w-full inline-flex items-center justify-center gap-2 bg-gradient-to-r from-[#1a1a1a] to-[#333] text-white px-5 py-3 rounded-xl font-bold uppercase text-xs tracking-widest hover:from-[#d4af37] hover:to-[#b5952f] transition-all duration-300 shadow-md hover:shadow-[#d4af37]/30">
                            <i class="fas fa-award"></i>
                            <span>View Report</span>
                            <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>

                    <!-- Customer Report -->
                    <div
                        class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col justify-between hover:shadow-lg transition-all duration-300">
                        <div>
                            <div
                                class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-md shadow-blue-500/20 mb-4">
                                <i class="fas fa-user-friends text-white text-lg"></i>
                            </div>
                            <h4 class="text-lg font-bold text-gray-900 mb-2" style="font-family: 'Playfair Display', serif;">
                                Customer Report
                            </h4>
                            <p class="text-sm text-gray-500 mb-6">
                                Analyze top spending customers, order counts, active buyers, and recent registrations.
                            </p>
                        </div>
                        <a href="{{ route('admin.reports.customers') }}"
                            class="w-full inline-flex items-center justify-center gap-2 bg-gradient-to-r from-[#1a1a1a] to-[#333] text-white px-5 py-3 rounded-xl font-bold uppercase text-xs tracking-widest hover:from-[#d4af37] hover:to-[#b5952f] transition-all duration-300 shadow-md hover:shadow-[#d4af37]/30">
                            <i class="fas fa-users"></i>
                            <span>View Report</span>
                            <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>

                    <!-- Customer Reviews & Ratings Report -->
                    <div
                        class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col justify-between hover:shadow-lg transition-all duration-300">
                        <div>
                            <div
                                class="w-12 h-12 bg-gradient-to-br from-amber-400 to-amber-500 rounded-xl flex items-center justify-center shadow-md shadow-amber-500/20 mb-4">
                                <i class="fas fa-star text-white text-lg"></i>
                            </div>
                            <h4 class="text-lg font-bold text-gray-900 mb-2" style="font-family: 'Playfair Display', serif;">
                                Customer Reviews & Ratings Report
                            </h4>
                            <p class="text-sm text-gray-500 mb-6">
                                Monitor star rating distribution, top-rated products, and detailed customer feedback.
                            </p>
                        </div>
                        <a href="{{ route('admin.reports.reviews') }}"
                            class="w-full inline-flex items-center justify-center gap-2 bg-gradient-to-r from-[#1a1a1a] to-[#333] text-white px-5 py-3 rounded-xl font-bold uppercase text-xs tracking-widest hover:from-[#d4af37] hover:to-[#b5952f] transition-all duration-300 shadow-md hover:shadow-[#d4af37]/30">
                            <i class="fas fa-star-half-alt"></i>
                            <span>View Report</span>
                            <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>

                    <!-- Inquiries / Complaints Report -->
                    <div
                        class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col justify-between hover:shadow-lg transition-all duration-300">
                        <div>
                            <div
                                class="w-12 h-12 bg-gradient-to-br from-rose-500 to-rose-600 rounded-xl flex items-center justify-center shadow-md shadow-rose-500/20 mb-4">
                                <i class="fas fa-exclamation-circle text-white text-lg"></i>
                            </div>
                            <h4 class="text-lg font-bold text-gray-900 mb-2" style="font-family: 'Playfair Display', serif;">
                                Inquiries / Complaints Report
                            </h4>
                            <p class="text-sm text-gray-500 mb-6">
                                Review inquiry volume, pending vs resolved status, resolution rate, and top reported products.
                            </p>
                        </div>
                        <a href="{{ route('admin.reports.inquiries') }}"
                            class="w-full inline-flex items-center justify-center gap-2 bg-gradient-to-r from-[#1a1a1a] to-[#333] text-white px-5 py-3 rounded-xl font-bold uppercase text-xs tracking-widest hover:from-[#d4af37] hover:to-[#b5952f] transition-all duration-300 shadow-md hover:shadow-[#d4af37]/30">
                            <i class="fas fa-clipboard-list"></i>
                            <span>View Report</span>
                            <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
