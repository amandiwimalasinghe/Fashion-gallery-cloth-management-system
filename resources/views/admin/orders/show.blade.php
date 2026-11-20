<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div
                    class="w-12 h-12 bg-gradient-to-br from-[#d4af37] to-[#b5952f] rounded-xl flex items-center justify-center shadow-lg shadow-[#d4af37]/20">
                    <i class="fas fa-receipt text-white text-lg"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900" style="font-family: 'Playfair Display', serif;">
                        Order #{{ $order->id }} Details
                    </h2>
                    <p class="text-sm text-gray-500">
                        Placed on {{ $order->created_at->format('F d, Y \a\t h:i A') }}
                    </p>
                </div>
            </div>

            <a href="{{ route('admin.orders') }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl border-2 border-gray-200 text-gray-600 font-semibold text-sm hover:border-[#d4af37] hover:text-[#d4af37] transition-all duration-300">
                <i class="fas fa-arrow-left"></i>
                <span>Back to Orders</span>
            </a>
        </div>
    </x-slot>

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

    <div class="py-12 bg-gradient-to-b from-gray-50 to-white min-h-screen">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            <!-- Top Overview Strip -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                    <div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Order ID</div>
                    <div class="text-2xl font-bold text-gray-900">#{{ $order->id }}</div>
                </div>

                <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                    <div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Order Status</div>
                    <span
                        class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider border {{ $config['bg'] }} {{ $config['text'] }} {{ $config['border'] }}">
                        <i class="fas {{ $config['icon'] }}"></i>
                        {{ ucfirst($order->status) }}
                    </span>
                </div>

                <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                    <div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Payment Method</div>
                    <span
                        class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-bold uppercase tracking-wider bg-gray-100 text-gray-700 border border-gray-200">
                        <i class="fas {{ $order->payment_method === 'stripe' ? 'fa-credit-card text-indigo-500' : 'fa-money-bill-wave text-green-600' }}"></i>
                        {{ strtoupper($order->payment_method ?? 'N/A') }}
                    </span>
                </div>

                <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                    <div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Total Amount</div>
                    <div class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-[#d4af37] to-[#b5952f]"
                        style="font-family: 'Playfair Display', serif;">
                        Rs. {{ number_format($order->total_amount, 2) }}
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Customer Details -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden h-fit">
                    <div class="bg-gradient-to-r from-gray-50 to-white px-6 py-4 border-b border-gray-100 flex items-center gap-2">
                        <i class="fas fa-user text-[#d4af37]"></i>
                        <h3 class="text-lg font-bold text-gray-900" style="font-family: 'Playfair Display', serif;">
                            Customer Details
                        </h3>
                    </div>

                    <div class="p-6 space-y-4">
                        <div class="flex items-center gap-3 pb-4 border-b border-gray-100">
                            <div
                                class="w-12 h-12 rounded-xl bg-gradient-to-br from-[#d4af37] to-[#b5952f] flex items-center justify-center text-white font-bold text-lg shadow-sm">
                                {{ strtoupper(substr($order->user->name ?? 'U', 0, 1)) }}
                            </div>
                            <div>
                                <div class="font-bold text-gray-900">{{ $order->user->name ?? 'Deleted User' }}</div>
                                <div class="text-xs text-gray-400">Customer ID: #{{ $order->user_id }}</div>
                            </div>
                        </div>

                        <div class="space-y-3 text-sm">
                            <div>
                                <div class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Email</div>
                                <div class="text-gray-700 font-medium mt-0.5 flex items-center gap-2">
                                    <i class="fas fa-envelope text-[#d4af37] text-xs"></i>
                                    {{ $order->user->email ?? 'N/A' }}
                                </div>
                            </div>

                            <div>
                                <div class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Phone</div>
                                <div class="text-gray-700 font-medium mt-0.5 flex items-center gap-2">
                                    <i class="fas fa-phone text-[#d4af37] text-xs"></i>
                                    {{ $order->user->phone ?? 'Not provided' }}
                                </div>
                            </div>

                            <div>
                                <div class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Delivery Address</div>
                                <div class="text-gray-700 font-medium mt-0.5 flex items-start gap-2">
                                    <i class="fas fa-map-marker-alt text-[#d4af37] text-xs mt-1"></i>
                                    <span>{{ $order->user->address ?? 'Not provided' }}</span>
                                </div>
                            </div>

                            <div class="pt-3 border-t border-gray-100">
                                <div class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Last Updated</div>
                                <div class="text-gray-600 text-xs mt-0.5">
                                    {{ $order->updated_at->format('M d, Y h:i A') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ordered Items -->
                <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-gray-50 to-white px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-shopping-bag text-[#d4af37]"></i>
                            <h3 class="text-lg font-bold text-gray-900" style="font-family: 'Playfair Display', serif;">
                                Ordered Items ({{ $order->items->sum('quantity') }})
                            </h3>
                        </div>
                    </div>

                    <div class="p-6 divide-y divide-gray-100">
                        @foreach($order->items as $item)
                            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-5 py-5 first:pt-0 last:pb-0">
                                <!-- Product Image -->
                                <div class="shrink-0 relative">
                                    @if($item->product?->image)
                                        <img src="{{ asset('storage/' . $item->product->image) }}"
                                            alt="{{ $item->product->name }}"
                                            class="w-20 h-20 object-cover rounded-xl border border-gray-200 shadow-sm">
                                    @else
                                        <div
                                            class="w-20 h-20 rounded-xl bg-gray-100 border border-gray-200 flex items-center justify-center text-gray-400">
                                            <i class="fas fa-tshirt text-2xl"></i>
                                        </div>
                                    @endif
                                    <span
                                        class="absolute -top-2 -right-2 bg-[#1a1a1a] text-white text-[11px] font-bold w-6 h-6 flex items-center justify-center rounded-full shadow">
                                        {{ $item->quantity }}x
                                    </span>
                                </div>

                                <!-- Product Info -->
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-bold text-gray-900 text-base">
                                        {{ $item->product->name ?? 'Removed Product' }}
                                    </h4>

                                    <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-xs text-gray-500 mt-1">
                                        @if($item->product?->category)
                                            <span>
                                                <i class="fas fa-tag text-[#d4af37] mr-1"></i>
                                                {{ $item->product->category }}
                                            </span>
                                        @endif
                                        @if($item->product?->size)
                                            <span>
                                                <i class="fas fa-ruler text-[#d4af37] mr-1"></i>
                                                Size: {{ $item->product->size }}
                                            </span>
                                        @endif
                                        @if($item->product?->user)
                                            <span>
                                                <i class="fas fa-palette text-[#d4af37] mr-1"></i>
                                                Designer: {{ $item->product->user->name }}
                                            </span>
                                        @endif
                                    </div>

                                    <div class="text-xs text-gray-400 mt-1.5">
                                        Unit Price: Rs. {{ number_format($item->price, 2) }} × {{ $item->quantity }}
                                    </div>
                                </div>

                                <!-- Line Subtotal -->
                                <div class="sm:text-right">
                                    <div class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Subtotal</div>
                                    <div class="text-base font-bold text-gray-900">
                                        Rs. {{ number_format($item->price * $item->quantity, 2) }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Order Total Footer -->
                    <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex items-center justify-between">
                        <span class="text-sm font-bold text-gray-600 uppercase tracking-wider">Grand Total</span>
                        <span
                            class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-[#d4af37] to-[#b5952f]"
                            style="font-family: 'Playfair Display', serif;">
                            Rs. {{ number_format($order->total_amount, 2) }}
                        </span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
