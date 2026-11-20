<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div
                    class="w-12 h-12 bg-gradient-to-br from-amber-400 to-amber-500 rounded-xl flex items-center justify-center shadow-lg shadow-amber-500/20">
                    <i class="fas fa-star text-white text-lg"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900" style="font-family: 'Playfair Display', serif;">
                        Customer Reviews & Ratings Report
                    </h2>
                    <p class="text-sm text-gray-500">Rating distribution, top-rated products, and customer feedback</p>
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
                'title' => 'Customer Reviews & Ratings Report',
                'subtitle' => 'Rating distribution, top-rated products, and customer feedback',
                'from' => $from,
                'to' => $to,
                'extraFilter' => $rating ? $rating . ' Stars' : null,
            ])

            <!-- Filters -->
            <form method="GET" action="{{ route('admin.reports.reviews') }}"
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
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Rating</label>
                    <select name="rating" class="rounded-xl border-gray-200 text-sm focus:border-[#d4af37] focus:ring-[#d4af37]">
                        <option value="">All Ratings</option>
                        @for($s = 5; $s >= 1; $s--)
                            <option value="{{ $s }}" {{ (string) $rating === (string) $s ? 'selected' : '' }}>{{ $s }} Stars</option>
                        @endfor
                    </select>
                </div>
                <button type="submit"
                    class="px-5 py-2.5 rounded-xl bg-[#1a1a1a] text-white text-xs font-bold uppercase tracking-wider hover:bg-[#d4af37] transition">
                    <i class="fas fa-filter mr-1"></i> Filter
                </button>
                @if($from || $to || $rating)
                    <a href="{{ route('admin.reports.reviews') }}"
                        class="px-4 py-2.5 rounded-xl border border-gray-200 text-gray-600 text-xs font-bold uppercase tracking-wider hover:bg-gray-50 transition">
                        Reset
                    </a>
                @endif
            </form>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-md">
                        <i class="fas fa-comments text-white text-xl"></i>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-gray-900">{{ $totalReviews }}</div>
                        <div class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Total Reviews</div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-amber-400 to-amber-500 rounded-xl flex items-center justify-center shadow-md">
                        <i class="fas fa-star text-white text-xl"></i>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-gray-900">{{ number_format($averageRating, 1) }}</div>
                        <div class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Average Rating</div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-md">
                        <i class="fas fa-thumbs-up text-white text-xl"></i>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-gray-900">{{ $fiveStarCount }}</div>
                        <div class="text-xs text-gray-400 uppercase tracking-wider font-semibold">5-Star Reviews</div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center shadow-md">
                        <i class="fas fa-exclamation-triangle text-white text-xl"></i>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-gray-900">{{ $lowRatingCount }}</div>
                        <div class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Low Ratings (1-2★)</div>
                    </div>
                </div>
            </div>

            <!-- Rating Distribution & Top Rated Products -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Distribution -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-bold text-gray-800 mb-5">
                        <i class="fas fa-chart-bar text-[#d4af37] mr-2"></i> Rating Distribution
                    </h3>
                    <div class="space-y-3">
                        @foreach($ratingDistribution as $star => $data)
                            <div class="flex items-center gap-3 text-sm">
                                <span class="w-14 font-bold text-gray-700">{{ $star }} <i class="fas fa-star text-amber-400"></i></span>
                                <div class="flex-1 bg-gray-100 rounded-full h-3 overflow-hidden">
                                    <div class="bg-gradient-to-r from-[#d4af37] to-amber-400 h-3 rounded-full"
                                        style="width: {{ $data['percent'] }}%"></div>
                                </div>
                                <span class="w-20 text-right text-xs text-gray-500 font-semibold">
                                    {{ $data['count'] }} ({{ $data['percent'] }}%)
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Top Rated Products -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-100 font-bold text-gray-800">
                        <i class="fas fa-trophy text-[#d4af37] mr-2"></i> Top Rated Products
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-100 text-xs uppercase text-gray-400">
                                    <th class="text-left p-4">Product</th>
                                    <th class="text-left p-4">Designer</th>
                                    <th class="text-right p-4">Reviews</th>
                                    <th class="text-right p-4">Avg.</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-sm">
                                @forelse($productRatings as $item)
                                    <tr>
                                        <td class="p-4 font-bold text-gray-800">{{ $item->name }}</td>
                                        <td class="p-4 text-gray-500">{{ $item->designer_name ?? 'N/A' }}</td>
                                        <td class="p-4 text-right text-gray-600">{{ $item->review_count }}</td>
                                        <td class="p-4 text-right font-bold text-amber-600">
                                            <i class="fas fa-star text-amber-400 mr-1"></i>{{ number_format($item->avg_rating, 1) }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="p-6 text-center text-gray-400">No rated products found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- All Reviews Table -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-100 font-bold text-gray-800">
                    <i class="fas fa-comment-dots text-[#d4af37] mr-2"></i> Customer Reviews List
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-100 text-xs uppercase text-gray-400">
                                <th class="text-left p-5">Customer</th>
                                <th class="text-left p-5">Product & Designer</th>
                                <th class="text-left p-5">Rating</th>
                                <th class="text-left p-5">Comment</th>
                                <th class="text-right p-5">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm">
                            @forelse($reviews as $review)
                                <tr class="hover:bg-gray-50/50">
                                    <td class="p-5 font-bold text-gray-800">{{ $review->user->name ?? 'Deleted User' }}</td>
                                    <td class="p-5">
                                        <div class="font-semibold text-gray-800">{{ $review->product->name ?? 'Removed Product' }}</div>
                                        <div class="text-xs text-gray-400">
                                            Designer: {{ $review->product?->user?->name ?? 'N/A' }}
                                        </div>
                                    </td>
                                    <td class="p-5 whitespace-nowrap">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star text-xs {{ $i <= $review->rating ? 'text-amber-400' : 'text-gray-200' }}"></i>
                                        @endfor
                                    </td>
                                    <td class="p-5 text-gray-600 max-w-md">{{ $review->comment ?: '—' }}</td>
                                    <td class="p-5 text-right text-xs text-gray-400 whitespace-nowrap">
                                        {{ $review->created_at->format('M d, Y') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-8 text-center text-gray-400">No reviews found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($reviews->hasPages())
                    <div class="p-5 border-t border-gray-100 no-print print:hidden">
                        {{ $reviews->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
