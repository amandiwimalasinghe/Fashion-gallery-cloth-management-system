<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div
                    class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg shadow-emerald-500/20">
                    <i class="fas fa-coins text-white text-lg"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900" style="font-family: 'Playfair Display', serif;">
                        Sales & Revenue Report
                    </h2>
                    <p class="text-sm text-gray-500">Revenue summary, payment breakdown, monthly trends, and top-selling products</p>
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
                'title' => 'Sales & Revenue Report',
                'subtitle' => 'Revenue summary, payment breakdown, monthly trends, and top-selling products',
                'from' => $from,
                'to' => $to,
            ])

            <!-- Date Range Filter -->
            <form method="GET" action="{{ route('admin.reports.sales') }}"
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
                    <a href="{{ route('admin.reports.sales') }}"
                        class="px-4 py-2.5 rounded-xl border border-gray-200 text-gray-600 text-xs font-bold uppercase tracking-wider hover:bg-gray-50 transition">
                        Reset
                    </a>
                @endif
            </form>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-md">
                        <i class="fas fa-coins text-white text-xl"></i>
                    </div>
                    <div>
                        <div class="text-xl font-bold text-gray-900">Rs. {{ number_format($totalRevenue, 2) }}</div>
                        <div class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Total Revenue</div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-md">
                        <i class="fas fa-shopping-bag text-white text-xl"></i>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-gray-900">{{ $totalOrders }}</div>
                        <div class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Total Orders</div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-[#d4af37] to-[#b5952f] rounded-xl flex items-center justify-center shadow-md">
                        <i class="fas fa-chart-line text-white text-xl"></i>
                    </div>
                    <div>
                        <div class="text-xl font-bold text-gray-900">Rs. {{ number_format($averageOrderValue, 2) }}</div>
                        <div class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Avg. Order Value</div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center shadow-md">
                        <i class="fas fa-times-circle text-white text-xl"></i>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-gray-900">{{ $cancelledOrders }}</div>
                        <div class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Cancelled Orders</div>
                    </div>
                </div>
            </div>

            <!-- Status & Payment Breakdowns -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Order Status Breakdown -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-100 font-bold text-gray-800">
                        <i class="fas fa-tasks text-[#d4af37] mr-2"></i> Order Status Breakdown
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-100 text-xs uppercase text-gray-400">
                                    <th class="text-left p-4">Status</th>
                                    <th class="text-right p-4">Orders</th>
                                    <th class="text-right p-4">Total Amount</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-sm">
                                @forelse($statusBreakdown as $row)
                                    <tr>
                                        <td class="p-4 font-semibold text-gray-800">{{ ucfirst($row->status) }}</td>
                                        <td class="p-4 text-right text-gray-600">{{ $row->order_count }}</td>
                                        <td class="p-4 text-right font-bold text-gray-900">Rs. {{ number_format($row->total_amount, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="p-6 text-center text-gray-400">No orders found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Payment Method Breakdown -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-100 font-bold text-gray-800">
                        <i class="fas fa-credit-card text-[#d4af37] mr-2"></i> Payment Method Breakdown
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-100 text-xs uppercase text-gray-400">
                                    <th class="text-left p-4">Payment Method</th>
                                    <th class="text-right p-4">Orders</th>
                                    <th class="text-right p-4">Revenue</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-sm">
                                @forelse($paymentBreakdown as $row)
                                    <tr>
                                        <td class="p-4 font-semibold text-gray-800">{{ strtoupper($row->payment_method ?? 'N/A') }}</td>
                                        <td class="p-4 text-right text-gray-600">{{ $row->order_count }}</td>
                                        <td class="p-4 text-right font-bold text-gray-900">Rs. {{ number_format($row->total_amount, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="p-6 text-center text-gray-400">No payment data found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Monthly Revenue -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-100 font-bold text-gray-800">
                    <i class="fas fa-calendar-alt text-[#d4af37] mr-2"></i> Monthly Sales Summary
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-100 text-xs uppercase text-gray-400">
                                <th class="text-left p-4">Month</th>
                                <th class="text-right p-4">Orders</th>
                                <th class="text-right p-4">Revenue</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm">
                            @forelse($monthlySales as $row)
                                <tr class="hover:bg-gray-50/50">
                                    <td class="p-4 font-bold text-gray-800">
                                        {{ \Carbon\Carbon::createFromFormat('Y-m', $row->month)->format('F Y') }}
                                    </td>
                                    <td class="p-4 text-right text-gray-600">{{ $row->order_count }}</td>
                                    <td class="p-4 text-right font-bold text-emerald-700">Rs. {{ number_format($row->revenue, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="p-6 text-center text-gray-400">No monthly sales data found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Top Selling Products -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-100 font-bold text-gray-800">
                    <i class="fas fa-fire text-[#d4af37] mr-2"></i> Top Selling Products
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-100 text-xs uppercase text-gray-400">
                                <th class="text-left p-4">#</th>
                                <th class="text-left p-4">Product</th>
                                <th class="text-left p-4">Category</th>
                                <th class="text-left p-4">Designer</th>
                                <th class="text-right p-4">Units Sold</th>
                                <th class="text-right p-4">Total Sales</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm">
                            @forelse($topProducts as $index => $product)
                                <tr class="hover:bg-gray-50/50">
                                    <td class="p-4 font-bold text-gray-400">{{ $index + 1 }}</td>
                                    <td class="p-4 font-bold text-gray-800">{{ $product->name }}</td>
                                    <td class="p-4 text-gray-600">{{ $product->category ?? 'N/A' }}</td>
                                    <td class="p-4 text-gray-600">{{ $product->designer_name ?? 'N/A' }}</td>
                                    <td class="p-4 text-right font-semibold text-gray-800">{{ $product->total_qty }}</td>
                                    <td class="p-4 text-right font-bold text-[#b5952f]">Rs. {{ number_format($product->total_sales, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-6 text-center text-gray-400">No product sales found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
