<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div
                class="w-12 h-12 bg-gradient-to-br from-[#d4af37] to-[#e5c76b] rounded-xl flex items-center justify-center shadow-lg shadow-[#d4af37]/20">
                <i class="fas fa-box-open text-white text-lg"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-900" style="font-family: 'Playfair Display', serif;">
                    {{ __('Manage Orders') }}
                </h2>
                <p class="text-sm text-gray-500">Track and update customer orders</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-b from-gray-50 to-white min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(count($orders) > 0)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="bg-gradient-to-r from-gray-50 to-white border-b border-gray-100">
                                    <th class="text-left p-5 text-xs font-bold text-gray-400 uppercase tracking-wider">Order
                                    </th>
                                    <th class="text-left p-5 text-xs font-bold text-gray-400 uppercase tracking-wider">
                                        Customer</th>
                                    <th class="text-left p-5 text-xs font-bold text-gray-400 uppercase tracking-wider">Items
                                    </th>
                                    <th class="text-left p-5 text-xs font-bold text-gray-400 uppercase tracking-wider">Total
                                    </th>
                                    <th class="text-left p-5 text-xs font-bold text-gray-400 uppercase tracking-wider">
                                        Status</th>
                                    <th class="text-left p-5 text-xs font-bold text-gray-400 uppercase tracking-wider">
                                        Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($orders as $order)
                                    <tr class="hover:bg-gray-50/50 transition-colors group">
                                        <!-- Order ID -->
                                        <td class="p-5">
                                            <div class="flex items-center gap-3">
                                                <div
                                                    class="w-10 h-10 bg-gradient-to-br from-[#d4af37] to-[#e5c76b] rounded-lg flex items-center justify-center text-white font-bold text-sm">
                                                    #{{ $order->id }}
                                                </div>
                                                <span
                                                    class="text-xs text-gray-400">{{ $order->created_at->format('M d') }}</span>
                                            </div>
                                        </td>

                                        <!-- Customer -->
                                        <td class="p-5">
                                            <div class="font-bold text-gray-800">{{ $order->user->name }}</div>
                                            <div class="text-xs text-gray-500 flex items-center gap-1 mt-1">
                                                <i class="fas fa-phone text-[8px]"></i>
                                                {{ $order->user->phone }}
                                            </div>
                                            <div class="text-xs text-gray-400 flex items-center gap-1">
                                                <i class="fas fa-map-marker-alt text-[8px]"></i>
                                                {{ Str::limit($order->user->address, 25) }}
                                            </div>
                                        </td>

                                        <!-- Items -->
                                        <td class="p-5">
                                            <ul class="text-sm space-y-1">
                                                @foreach($order->items as $item)
                                                    @if($item->product->user_id === Auth::id())
                                                        <li class="flex items-center gap-2 text-gray-600">
                                                            <span class="w-1.5 h-1.5 rounded-full bg-[#d4af37]"></span>
                                                            {{ $item->product->name }}
                                                            <span class="text-xs text-gray-400">(x{{ $item->quantity }})</span>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </td>

                                        <!-- Total -->
                                        <td class="p-5">
                                            <span
                                                class="text-lg font-bold text-transparent bg-clip-text bg-gradient-to-r from-[#d4af37] to-[#b5952f]">
                                                Rs. {{ number_format($order->total_amount, 2) }}
                                            </span>
                                        </td>

                                        <!-- Status -->
                                        <td class="p-5">
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
                                        <td class="p-5">
                                            @if($order->status !== 'completed' && $order->status !== 'cancelled')
                                                <form action="{{ route('designer.orders.update', $order->id) }}" method="POST"
                                                    class="flex items-center gap-2">
                                                    @csrf
                                                    <select name="status"
                                                        class="text-sm border-gray-200 bg-gray-50 rounded-xl py-2 px-3 focus:border-[#d4af37] focus:ring-[#d4af37] cursor-pointer">
                                                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>
                                                            Pending</option>
                                                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>
                                                            Shipped</option>
                                                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancel</option>
                                                    </select>
                                                    <button type="submit"
                                                        class="w-10 h-10 bg-gradient-to-r from-[#1a1a1a] to-[#333] text-white rounded-xl flex items-center justify-center hover:from-[#d4af37] hover:to-[#b5952f] transition-all duration-300 shadow-md">
                                                        <i class="fas fa-save"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-gray-400 text-xs flex items-center gap-1">
                                                    <i class="fas fa-lock"></i>
                                                    Locked
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-24 bg-white rounded-3xl shadow-sm border border-gray-100">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-inbox text-gray-300 text-4xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2" style="font-family: 'Playfair Display', serif;">No
                        Orders Yet</h3>
                    <p class="text-gray-500 max-w-md mx-auto">You haven't received any orders yet. Your orders will appear
                        here once customers make purchases.</p>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>