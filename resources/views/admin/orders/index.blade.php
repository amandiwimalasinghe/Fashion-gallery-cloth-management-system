<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div
                    class="w-12 h-12 bg-gradient-to-br from-[#d4af37] to-[#b5952f] rounded-xl flex items-center justify-center shadow-lg shadow-[#d4af37]/20">
                    <i class="fas fa-box-open text-white text-lg"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900" style="font-family: 'Playfair Display', serif;">
                        {{ __('Order Management') }}
                    </h2>
                    <p class="text-sm text-gray-500">Admin Dashboard - View all customer orders and statuses</p>
                </div>
            </div>

            <a href="{{ route('admin.dashboard') }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl border-2 border-gray-200 text-gray-600 font-semibold text-sm hover:border-[#d4af37] hover:text-[#d4af37] transition-all duration-300">
                <i class="fas fa-arrow-left"></i>
                <span>Back to Admin Panel</span>
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-b from-gray-50 to-white min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(session('success'))
                <div
                    class="mb-6 bg-green-50 border border-green-200 text-green-700 px-5 py-4 rounded-2xl flex items-center gap-3 shadow-sm">
                    <i class="fas fa-check-circle text-green-500 text-lg"></i>
                    <span class="font-medium text-sm">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div
                    class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4 hover:shadow-lg transition-shadow">
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-md">
                        <i class="fas fa-shopping-bag text-white text-xl"></i>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-gray-900">{{ $totalOrders }}</div>
                        <div class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Total Orders</div>
                    </div>
                </div>

                <div
                    class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4 hover:shadow-lg transition-shadow">
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-amber-400 to-amber-500 rounded-xl flex items-center justify-center shadow-md">
                        <i class="fas fa-clock text-white text-xl"></i>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-gray-900">{{ $pendingOrders }}</div>
                        <div class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Pending</div>
                    </div>
                </div>

                <div
                    class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4 hover:shadow-lg transition-shadow">
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-md">
                        <i class="fas fa-check-circle text-white text-xl"></i>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-gray-900">{{ $completedOrders }}</div>
                        <div class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Completed</div>
                    </div>
                </div>

                <div
                    class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4 hover:shadow-lg transition-shadow">
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-[#d4af37] to-[#b5952f] rounded-xl flex items-center justify-center shadow-md">
                        <i class="fas fa-coins text-white text-xl"></i>
                    </div>
                    <div>
                        <div class="text-xl font-bold text-gray-900">Rs. {{ number_format($totalRevenue, 2) }}</div>
                        <div class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Total Revenue</div>
                    </div>
                </div>
            </div>

            <!-- Status Filter Tabs -->
            <div class="flex flex-wrap items-center gap-2 mb-6">
                @php
                    $statuses = [
                        '' => 'All Orders',
                        'pending' => 'Pending',
                        'shipped' => 'Shipped',
                        'delivered' => 'Delivered',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ];
                    $currentStatus = request('status', '');
                @endphp

                @foreach($statuses as $key => $label)
                    <a href="{{ $key === '' ? route('admin.orders') : route('admin.orders', ['status' => $key]) }}"
                        class="px-4 py-2 rounded-full text-xs font-bold uppercase tracking-wider transition-all duration-200 {{ $currentStatus === $key ? 'bg-[#1a1a1a] text-white shadow-md' : 'bg-white text-gray-600 border border-gray-200 hover:border-[#d4af37] hover:text-[#d4af37]' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>

            @if($orders->count() > 0)
                <!-- Orders Table -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="bg-gradient-to-r from-gray-50 to-white border-b border-gray-100">
                                    <th class="text-left p-5 text-xs font-bold text-gray-400 uppercase tracking-wider">Order</th>
                                    <th class="text-left p-5 text-xs font-bold text-gray-400 uppercase tracking-wider">Customer Details</th>
                                    <th class="text-left p-5 text-xs font-bold text-gray-400 uppercase tracking-wider">Ordered Items</th>
                                    <th class="text-left p-5 text-xs font-bold text-gray-400 uppercase tracking-wider">Payment & Total</th>
                                    <th class="text-left p-5 text-xs font-bold text-gray-400 uppercase tracking-wider">Status</th>
                                    <th class="text-left p-5 text-xs font-bold text-gray-400 uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($orders as $order)
                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        <!-- Order ID & Date -->
                                        <td class="p-5 align-top">
                                            <div class="flex items-center gap-3">
                                                <div
                                                    class="w-11 h-11 bg-gradient-to-br from-[#d4af37] to-[#e5c76b] rounded-xl flex items-center justify-center text-white font-bold text-sm shadow-sm">
                                                    #{{ $order->id }}
                                                </div>
                                                <div>
                                                    <div class="text-sm font-bold text-gray-800">
                                                        {{ $order->created_at->format('M d, Y') }}
                                                    </div>
                                                    <div class="text-xs text-gray-400">
                                                        {{ $order->created_at->format('h:i A') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Customer Details -->
                                        <td class="p-5 align-top">
                                            <div class="font-bold text-gray-800">{{ $order->user->name ?? 'Deleted User' }}</div>
                                            @if($order->user?->email)
                                                <div class="text-xs text-gray-500 flex items-center gap-1.5 mt-1">
                                                    <i class="fas fa-envelope text-[#d4af37] text-[10px]"></i>
                                                    {{ $order->user->email }}
                                                </div>
                                            @endif
                                            @if($order->user?->phone)
                                                <div class="text-xs text-gray-500 flex items-center gap-1.5 mt-0.5">
                                                    <i class="fas fa-phone text-[#d4af37] text-[10px]"></i>
                                                    {{ $order->user->phone }}
                                                </div>
                                            @endif
                                            @if($order->user?->address)
                                                <div class="text-xs text-gray-400 flex items-center gap-1.5 mt-0.5">
                                                    <i class="fas fa-map-marker-alt text-[#d4af37] text-[10px]"></i>
                                                    {{ $order->user->address }}
                                                </div>
                                            @endif
                                        </td>

                                        <!-- Ordered Items -->
                                        <td class="p-5 align-top">
                                            <ul class="space-y-2">
                                                @foreach($order->items as $item)
                                                    <li class="text-sm bg-gray-50 rounded-xl px-3 py-2 border border-gray-100">
                                                        <div class="flex items-center justify-between gap-3">
                                                            <span class="font-semibold text-gray-800">
                                                                {{ $item->product->name ?? 'Removed Product' }}
                                                            </span>
                                                            <span class="text-xs font-bold text-gray-500">
                                                                x{{ $item->quantity }}
                                                            </span>
                                                        </div>
                                                        <div class="flex items-center justify-between gap-3 text-xs text-gray-400 mt-0.5">
                                                            <span>
                                                                @if($item->product?->user)
                                                                    Designer: {{ $item->product->user->name }}
                                                                @endif
                                                            </span>
                                                            <span class="font-semibold text-gray-600">
                                                                Rs. {{ number_format($item->price * $item->quantity, 2) }}
                                                            </span>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </td>

                                        <!-- Payment & Total -->
                                        <td class="p-5 align-top">
                                            <div
                                                class="text-lg font-bold text-transparent bg-clip-text bg-gradient-to-r from-[#d4af37] to-[#b5952f]">
                                                Rs. {{ number_format($order->total_amount, 2) }}
                                            </div>
                                            <span
                                                class="inline-flex items-center gap-1.5 mt-2 px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider bg-gray-100 text-gray-600 border border-gray-200">
                                                <i class="fas {{ $order->payment_method === 'stripe' ? 'fa-credit-card text-indigo-500' : 'fa-money-bill-wave text-green-600' }}"></i>
                                                {{ strtoupper($order->payment_method ?? 'N/A') }}
                                            </span>
                                        </td>

                                        <!-- Status Badge -->
                                        <td class="p-5 align-top">
                                            @php
                                                $statusConfig = [
                                                    'pending' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'border' => 'border-amber-200', 'icon' => 'fa-clock'],
                                                    'shipped' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-700', 'border' => 'border-blue-200', 'icon' => 'fa-truck'],
                                                    'delivered' => ['bg' => 'bg-purple-50', 'text' => 'text-purple-700', 'border' => 'border-purple-200', 'icon' => 'fa-box-open'],
                                                    'completed' => ['bg' => 'bg-green-50', 'text' => 'text-green-700', 'border' => 'border-green-200', 'icon' => 'fa-check-circle'],
                                                    'cancelled' => ['bg' => 'bg-red-50', 'text' => 'text-red-700', 'border' => 'border-red-200', 'icon' => 'fa-times-circle'],
                                                ];
                                                $config = $statusConfig[$order->status] ?? $statusConfig['pending'];
                                            @endphp
                                            <span
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-wider border {{ $config['bg'] }} {{ $config['text'] }} {{ $config['border'] }}">
                                                <i class="fas {{ $config['icon'] }}"></i>
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>

                                        <!-- Action -->
                                        <td class="p-5 align-top">
                                            <a href="{{ route('admin.orders.show', $order->id) }}"
                                                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-gradient-to-r from-[#1a1a1a] to-[#333] text-white text-xs font-bold uppercase tracking-wider hover:from-[#d4af37] hover:to-[#b5952f] transition-all duration-300 shadow-sm hover:shadow-[#d4af37]/30">
                                                <i class="fas fa-eye"></i>
                                                <span>View</span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($orders->hasPages())
                        <div class="p-5 border-t border-gray-100">
                            {{ $orders->links() }}
                        </div>
                    @endif
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-24 bg-white rounded-3xl shadow-sm border border-gray-100">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-inbox text-gray-300 text-4xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2" style="font-family: 'Playfair Display', serif;">
                        No Orders Found
                    </h3>
                    <p class="text-gray-500 max-w-md mx-auto">
                        There are no orders matching this view yet.
                    </p>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
