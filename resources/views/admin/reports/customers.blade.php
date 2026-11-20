<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div
                    class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/20">
                    <i class="fas fa-user-friends text-white text-lg"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900" style="font-family: 'Playfair Display', serif;">
                        Customer Report
                    </h2>
                    <p class="text-sm text-gray-500">Top customers, purchase activity, total spending, and registrations</p>
                </div>
            </div>

            <div class="flex items-center gap-3 print:hidden">
                <button type="button" onclick="window.print()"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-[#1a1a1a] to-[#333] text-white font-semibold text-sm hover:from-[#d4af37] hover:to-[#b5952f] transition-all duration-300 shadow-sm">
                    <i class="fas fa-print"></i>
                    <span>Print Report</span>
                </button>
                <a href="{{ route('admin.dashboard') }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl border-2 border-gray-200 text-gray-600 font-semibold text-sm hover:border-[#d4af37] hover:text-[#d4af37] transition-all duration-300">
                    <i class="fas fa-arrow-left"></i>
                    <span>Back to Admin</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-b from-gray-50 to-white min-h-screen report-printable">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            @include('admin.reports.partials.print-header', [
                'title' => 'Customer Report',
                'subtitle' => 'Top customers, purchase activity, total spending, and registrations',
                'from' => $from,
                'to' => $to,
            ])

            <!-- Date Range Filter -->
            <form method="GET" action="{{ route('admin.reports.customers') }}"
                class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-wrap items-end gap-4 no-print print:hidden">
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">From Date</label>
                    <input type="date" name="from" value="{{ $from }}"
                        class="rounded-xl border-gray-200 text-sm focus:border-[#d4af37] focus:ring-[#d4af37]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">To Date</label>
                    <input type="date" name="to" value="{{ $to }}"
                        class="rounded-xl border-gray-200 text-sm focus:border-[#d4af37] focus:ring-[#d4af37]">
                </div>
                <button type="submit"
                    class="px-5 py-2.5 rounded-xl bg-[#1a1a1a] text-white text-xs font-bold uppercase tracking-wider hover:bg-[#d4af37] transition">
                    <i class="fas fa-filter mr-1"></i> Filter
                </button>
                @if($from || $to)
                    <a href="{{ route('admin.reports.customers') }}"
                        class="px-4 py-2.5 rounded-xl border border-gray-200 text-gray-600 text-xs font-bold uppercase tracking-wider hover:bg-gray-50 transition">
                        Reset
                    </a>
                @endif
            </form>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-md">
                        <i class="fas fa-users text-white text-xl"></i>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-gray-900">{{ $totalCustomers }}</div>
                        <div class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Total Customers</div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-md">
                        <i class="fas fa-shopping-cart text-white text-xl"></i>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-gray-900">{{ $activeBuyers }}</div>
                        <div class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Active Buyers</div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-md">
                        <i class="fas fa-user-plus text-white text-xl"></i>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-gray-900">{{ $newCustomers }}</div>
                        <div class="text-xs text-gray-400 uppercase tracking-wider font-semibold">
                            {{ $from || $to ? 'Joined in Period' : 'New This Month' }}
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-[#d4af37] to-[#b5952f] rounded-xl flex items-center justify-center shadow-md">
                        <i class="fas fa-wallet text-white text-xl"></i>
                    </div>
                    <div>
                        <div class="text-xl font-bold text-gray-900">Rs. {{ number_format($totalCustomerSpend, 2) }}</div>
                        <div class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Total Spending</div>
                    </div>
                </div>
            </div>

            <!-- Customers Table -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-100 font-bold text-gray-800">
                    <i class="fas fa-list text-[#d4af37] mr-2"></i> Customer Activity & Spending
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-100 text-xs uppercase text-gray-400">
                                <th class="text-left p-5">Customer</th>
                                <th class="text-left p-5">Joined</th>
                                <th class="text-right p-5">Total Orders</th>
                                <th class="text-right p-5">Completed</th>
                                <th class="text-right p-5">Total Spent</th>
                                <th class="text-right p-5">Last Order</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm">
                            @forelse($customerStats as $customer)
                                <tr class="hover:bg-gray-50/50">
                                    <td class="p-5">
                                        <div class="font-bold text-gray-900">{{ $customer->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $customer->email }}</div>
                                        @if($customer->phone)
                                            <div class="text-xs text-gray-400">{{ $customer->phone }}</div>
                                        @endif
                                    </td>
                                    <td class="p-5 text-gray-600 text-xs">
                                        {{ $customer->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="p-5 text-right font-semibold text-gray-800">{{ $customer->total_orders }}</td>
                                    <td class="p-5 text-right text-green-600 font-semibold">{{ $customer->completed_orders }}</td>
                                    <td class="p-5 text-right font-bold text-[#b5952f]">
                                        Rs. {{ number_format($customer->total_spent, 2) }}
                                    </td>
                                    <td class="p-5 text-right text-xs text-gray-500">
                                        {{ $customer->last_order_at ? \Carbon\Carbon::parse($customer->last_order_at)->format('M d, Y') : 'No orders' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-8 text-center text-gray-400">No customers found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
