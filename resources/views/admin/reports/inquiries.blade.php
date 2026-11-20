<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div
                    class="w-12 h-12 bg-gradient-to-br from-rose-500 to-rose-600 rounded-xl flex items-center justify-center shadow-lg shadow-rose-500/20">
                    <i class="fas fa-exclamation-circle text-white text-lg"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900" style="font-family: 'Playfair Display', serif;">
                        Inquiries / Complaints Report
                    </h2>
                    <p class="text-sm text-gray-500">Customer complaint statistics, resolution rates, and inquiry log</p>
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
                'title' => 'Inquiries / Complaints Report',
                'subtitle' => 'Customer complaint statistics, resolution rates, and inquiry log',
                'from' => $from,
                'to' => $to,
                'extraFilter' => $status ? 'Status: ' . ucfirst($status) : null,
            ])

            <!-- Filters -->
            <form method="GET" action="{{ route('admin.reports.inquiries') }}"
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
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Status</label>
                    <select name="status" class="rounded-xl border-gray-200 text-sm focus:border-[#d4af37] focus:ring-[#d4af37]">
                        <option value="">All Statuses</option>
                        <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ $status === 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="resolved" {{ $status === 'resolved' ? 'selected' : '' }}>Resolved</option>
                    </select>
                </div>
                <button type="submit"
                    class="px-5 py-2.5 rounded-xl bg-[#1a1a1a] text-white text-xs font-bold uppercase tracking-wider hover:bg-[#d4af37] transition">
                    <i class="fas fa-filter mr-1"></i> Filter
                </button>
                @if($from || $to || $status)
                    <a href="{{ route('admin.reports.inquiries') }}"
                        class="px-4 py-2.5 rounded-xl border border-gray-200 text-gray-600 text-xs font-bold uppercase tracking-wider hover:bg-gray-50 transition">
                        Reset
                    </a>
                @endif
            </form>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-5">
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
                    <div class="text-xs text-gray-400 uppercase tracking-wider font-bold mb-1">Total Inquiries</div>
                    <div class="text-3xl font-bold text-gray-900">{{ $totalInquiries }}</div>
                </div>

                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
                    <div class="text-xs text-amber-500 uppercase tracking-wider font-bold mb-1">Pending</div>
                    <div class="text-3xl font-bold text-amber-600">{{ $pendingInquiries }}</div>
                </div>

                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
                    <div class="text-xs text-blue-500 uppercase tracking-wider font-bold mb-1">Processing</div>
                    <div class="text-3xl font-bold text-blue-600">{{ $processingInquiries }}</div>
                </div>

                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
                    <div class="text-xs text-green-500 uppercase tracking-wider font-bold mb-1">Resolved</div>
                    <div class="text-3xl font-bold text-green-600">{{ $resolvedInquiries }}</div>
                </div>

                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
                    <div class="text-xs text-[#b5952f] uppercase tracking-wider font-bold mb-1">Resolution Rate</div>
                    <div class="text-3xl font-bold text-gray-900">{{ $resolutionRate }}%</div>
                </div>
            </div>

            <!-- Most Inquired Products -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-100 font-bold text-gray-800">
                    <i class="fas fa-box text-[#d4af37] mr-2"></i> Most Inquired / Reported Products
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-100 text-xs uppercase text-gray-400">
                                <th class="text-left p-4">Product</th>
                                <th class="text-left p-4">Designer</th>
                                <th class="text-right p-4">Total Inquiries</th>
                                <th class="text-right p-4">Resolved</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm">
                            @forelse($topInquiredProducts as $item)
                                <tr class="hover:bg-gray-50/50">
                                    <td class="p-4 font-bold text-gray-800">{{ $item->name }}</td>
                                    <td class="p-4 text-gray-500">{{ $item->designer_name ?? 'N/A' }}</td>
                                    <td class="p-4 text-right font-semibold text-gray-800">{{ $item->inquiry_count }}</td>
                                    <td class="p-4 text-right font-semibold text-green-600">{{ $item->resolved_count }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-6 text-center text-gray-400">No product inquiry data found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Inquiries Log -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-100 font-bold text-gray-800">
                    <i class="fas fa-clipboard-list text-[#d4af37] mr-2"></i> Inquiries & Complaints Details
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-100 text-xs uppercase text-gray-400">
                                <th class="text-left p-5">ID & Date</th>
                                <th class="text-left p-5">Customer</th>
                                <th class="text-left p-5">Product & Order</th>
                                <th class="text-left p-5">Message & Reply</th>
                                <th class="text-left p-5">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm">
                            @forelse($inquiries as $inq)
                                @php
                                    $statusConfig = [
                                        'pending' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'border' => 'border-amber-200', 'icon' => 'fa-clock'],
                                        'processing' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-700', 'border' => 'border-blue-200', 'icon' => 'fa-spinner'],
                                        'resolved' => ['bg' => 'bg-green-50', 'text' => 'text-green-700', 'border' => 'border-green-200', 'icon' => 'fa-check-circle'],
                                    ];
                                    $config = $statusConfig[$inq->status] ?? $statusConfig['pending'];
                                @endphp
                                <tr class="hover:bg-gray-50/50">
                                    <td class="p-5 align-top whitespace-nowrap">
                                        <div class="font-bold text-gray-800">#{{ $inq->id }}</div>
                                        <div class="text-xs text-gray-400">{{ $inq->created_at->format('M d, Y') }}</div>
                                    </td>
                                    <td class="p-5 align-top">
                                        <div class="font-bold text-gray-800">{{ $inq->user->name ?? 'Deleted User' }}</div>
                                        <div class="text-xs text-gray-400">{{ $inq->user->email ?? '' }}</div>
                                    </td>
                                    <td class="p-5 align-top">
                                        <div class="font-semibold text-gray-800">{{ $inq->product->name ?? 'Removed Product' }}</div>
                                        <div class="text-xs text-gray-400">Order #{{ $inq->order_id }}</div>
                                    </td>
                                    <td class="p-5 align-top max-w-md">
                                        <div class="text-gray-700">{{ $inq->message }}</div>
                                        @if($inq->admin_reply)
                                            <div class="mt-2 text-xs bg-gray-50 border border-gray-200 rounded-lg p-2.5 text-gray-600">
                                                <span class="font-bold text-[#b5952f]">Admin Reply:</span> {{ $inq->admin_reply }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="p-5 align-top">
                                        <span
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-wider border {{ $config['bg'] }} {{ $config['text'] }} {{ $config['border'] }}">
                                            <i class="fas {{ $config['icon'] }}"></i>
                                            {{ ucfirst($inq->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-8 text-center text-gray-400">No inquiries found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($inquiries->hasPages())
                    <div class="p-5 border-t border-gray-100 no-print print:hidden">
                        {{ $inquiries->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
