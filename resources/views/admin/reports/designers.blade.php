<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div
                    class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg shadow-purple-500/20">
                    <i class="fas fa-palette text-white text-lg"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900" style="font-family: 'Playfair Display', serif;">
                        Designer Performance Report
                    </h2>
                    <p class="text-sm text-gray-500">Designer sales volume, product listings, revenue, and customer ratings</p>
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
                'title' => 'Designer Performance Report',
                'subtitle' => 'Designer sales volume, product listings, revenue, and customer ratings',
                'from' => $from,
                'to' => $to,
            ])

            <!-- Date Range Filter -->
            <form method="GET" action="{{ route('admin.reports.designers') }}"
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
                    <a href="{{ route('admin.reports.designers') }}"
                        class="px-4 py-2.5 rounded-xl border border-gray-200 text-gray-600 text-xs font-bold uppercase tracking-wider hover:bg-gray-50 transition">
                        Reset
                    </a>
                @endif
            </form>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center shadow-md">
                        <i class="fas fa-palette text-white text-xl"></i>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-gray-900">{{ $totalDesigners }}</div>
                        <div class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Total Designers</div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-md">
                        <i class="fas fa-tshirt text-white text-xl"></i>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-gray-900">{{ $totalProducts }}</div>
                        <div class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Listed Products</div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-[#d4af37] to-[#b5952f] rounded-xl flex items-center justify-center shadow-md">
                        <i class="fas fa-coins text-white text-xl"></i>
                    </div>
                    <div>
                        <div class="text-xl font-bold text-gray-900">Rs. {{ number_format($totalDesignerRevenue, 2) }}</div>
                        <div class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Designer Revenue</div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-amber-400 to-amber-500 rounded-xl flex items-center justify-center shadow-md">
                        <i class="fas fa-star text-white text-xl"></i>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-gray-900">{{ number_format($overallAvgRating, 1) }}</div>
                        <div class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Avg. Rating</div>
                    </div>
                </div>
            </div>

            <!-- Designer Performance Table -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-100 font-bold text-gray-800">
                    <i class="fas fa-award text-[#d4af37] mr-2"></i> Designer Performance Breakdown
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-100 text-xs uppercase text-gray-400">
                                <th class="text-left p-5">Designer</th>
                                <th class="text-right p-5">Products</th>
                                <th class="text-right p-5">Orders</th>
                                <th class="text-right p-5">Items Sold</th>
                                <th class="text-right p-5">Total Revenue</th>
                                <th class="text-right p-5">Avg. Rating</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm">
                            @forelse($designerStats as $designer)
                                <tr class="hover:bg-gray-50/50">
                                    <td class="p-5">
                                        <div class="font-bold text-gray-900">{{ $designer->name }}</div>
                                        @if($designer->company_name)
                                            <div class="text-xs text-[#b5952f] font-medium">{{ $designer->company_name }}</div>
                                        @endif
                                        <div class="text-xs text-gray-400">{{ $designer->email }}</div>
                                    </td>
                                    <td class="p-5 text-right font-semibold text-gray-700">{{ $designer->products_count }}</td>
                                    <td class="p-5 text-right text-gray-600">{{ $designer->total_orders }}</td>
                                    <td class="p-5 text-right font-semibold text-gray-800">{{ $designer->items_sold }}</td>
                                    <td class="p-5 text-right font-bold text-[#b5952f]">Rs. {{ number_format($designer->total_revenue, 2) }}</td>
                                    <td class="p-5 text-right">
                                        @if($designer->review_count > 0)
                                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-amber-50 text-amber-700 border border-amber-200 font-bold text-xs">
                                                <i class="fas fa-star text-amber-400"></i>
                                                {{ number_format($designer->avg_rating, 1) }}
                                                <span class="text-amber-500 font-normal">({{ $designer->review_count }})</span>
                                            </span>
                                        @else
                                            <span class="text-xs text-gray-400">No reviews</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-8 text-center text-gray-400">No designers found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
