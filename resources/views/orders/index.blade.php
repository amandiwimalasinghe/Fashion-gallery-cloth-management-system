<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div
                class="w-12 h-12 bg-gradient-to-br from-[#d4af37] to-[#e5c76b] rounded-xl flex items-center justify-center shadow-lg shadow-[#d4af37]/20">
                <i class="fas fa-box text-white text-lg"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-900" style="font-family: 'Playfair Display', serif;">
                    My Orders
                </h2>
                <p class="text-sm text-gray-500">Track and manage your purchases</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-b from-gray-50 to-white min-h-screen">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            @forelse($orders as $order)
                <div
                    class="bg-white overflow-hidden shadow-sm hover:shadow-xl transition-all duration-500 rounded-2xl mb-8 border border-gray-100 group">

                    <!-- Order Header -->
                    <div class="bg-gradient-to-r from-gray-50 to-white px-6 py-5 border-b border-gray-100">
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                            <!-- Order Icon & ID -->
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-14 h-14 bg-gradient-to-br from-[#d4af37] to-[#e5c76b] rounded-xl flex items-center justify-center shadow-md group-hover:shadow-lg transition-shadow">
                                    <i class="fas fa-shopping-bag text-white text-xl"></i>
                                </div>
                                <div>
                                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Order
                                        ID</span>
                                    <div class="text-xl font-bold text-gray-800">#{{ $order->id }}</div>
                                </div>
                            </div>

                            <!-- Date -->
                            <div class="text-center md:text-left">
                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Placed On</span>
                                <div class="text-sm font-medium text-gray-600 flex items-center gap-1">
                                    <i class="fas fa-calendar text-[#d4af37] text-xs"></i>
                                    {{ $order->created_at->format('M d, Y') }}
                                </div>
                            </div>

                            <!-- Total -->
                            <div class="text-center md:text-right">
                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Total
                                    Amount</span>
                                <div class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-[#d4af37] to-[#b5952f]"
                                    style="font-family: 'Playfair Display', serif;">
                                    Rs. {{ number_format($order->total_amount, 2) }}
                                </div>
                            </div>

                            <!-- Status Badge -->
                            <div>
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
                                    class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs font-bold uppercase tracking-widest border {{ $config['bg'] }} {{ $config['text'] }} {{ $config['border'] }}">
                                    <i class="fas {{ $config['icon'] }}"></i>
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="p-6 divide-y divide-gray-100">
                        @foreach($order->items as $item)
                            <div x-data="{ showModal: false, rating: 0, hoverRating: 0 }"
                                class="flex flex-col sm:flex-row items-center gap-6 py-6 first:pt-0 last:pb-0">

                                <!-- Product Image -->
                                <div class="shrink-0 relative group/img">
                                    <img src="{{ asset('storage/' . $item->product->image) }}"
                                        class="w-24 h-24 object-cover rounded-xl shadow-sm border border-gray-200 group-hover/img:border-[#d4af37]/50 transition-colors">
                                    <span
                                        class="absolute -top-2 -right-2 bg-gradient-to-r from-[#1a1a1a] to-[#333] text-white text-xs font-bold w-7 h-7 flex items-center justify-center rounded-full shadow-md">
                                        {{ $item->quantity }}x
                                    </span>
                                </div>

                                <!-- Product Details -->
                                <div class="flex-1 text-center sm:text-left">
                                    <h4 class="font-bold text-gray-900 text-lg" style="font-family: 'Playfair Display', serif;">
                                        {{ $item->product->name }}</h4>
                                    <p class="text-sm text-gray-500 mt-1">Unit Price: Rs. {{ number_format($item->price, 2) }}
                                    </p>
                                </div>

                                <!-- Rate Button (Only for completed orders) -->
                                @if($order->status === 'completed')
                                    <button @click="showModal = true"
                                        class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-[#1a1a1a] to-[#333] text-white rounded-full font-bold text-sm uppercase tracking-wider hover:from-[#d4af37] hover:to-[#b5952f] transition-all duration-300 shadow-lg hover:shadow-[#d4af37]/30 group/btn">
                                        <i class="fas fa-star text-yellow-400 group-hover/btn:animate-pulse"></i>
                                        <span>Rate Product</span>
                                    </button>

                                    <!-- Rating Modal -->
                                    <div x-show="showModal" style="display: none;"
                                        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
                                        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
                                        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                        class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">

                                        <div class="flex items-center justify-center min-h-screen p-4">
                                            <div class="fixed inset-0 bg-gray-900/80 backdrop-blur-sm" @click="showModal = false">
                                            </div>

                                            <div
                                                class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full p-8 border-t-4 border-[#d4af37] transform transition-all">
                                                <form action="{{ route('reviews.store') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                                                    <input type="hidden" name="order_id" value="{{ $order->id }}">

                                                    <!-- Modal Header -->
                                                    <div class="text-center mb-6">
                                                        <div
                                                            class="w-16 h-16 bg-gradient-to-br from-yellow-400 to-amber-500 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                                                            <i class="fas fa-star text-white text-2xl"></i>
                                                        </div>
                                                        <h3 class="text-2xl font-bold text-gray-900"
                                                            style="font-family: 'Playfair Display', serif;">Rate & Review</h3>
                                                        <p class="text-sm text-gray-500 mt-2">How was your experience with
                                                            <strong>{{ $item->product->name }}</strong>?</p>
                                                    </div>

                                                    <!-- Star Rating -->
                                                    <div class="mb-6 text-center">
                                                        <label
                                                            class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Your
                                                            Rating</label>
                                                        <div class="flex justify-center gap-2">
                                                            <template x-for="star in 5">
                                                                <i class="fas fa-star text-3xl cursor-pointer transition-all duration-200"
                                                                    :class="(hoverRating >= star || rating >= star) ? 'text-yellow-400 scale-110' : 'text-gray-300'"
                                                                    @click="rating = star" @mouseover="hoverRating = star"
                                                                    @mouseleave="hoverRating = 0"></i>
                                                            </template>
                                                        </div>
                                                        <input type="hidden" name="rating" :value="rating" required>
                                                    </div>

                                                    <!-- Review Text -->
                                                    <div class="mb-6">
                                                        <label
                                                            class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Your
                                                            Review</label>
                                                        <textarea name="comment" rows="4"
                                                            class="w-full border-2 border-gray-200 rounded-xl focus:border-[#d4af37] focus:ring-[#d4af37] transition-all p-4 placeholder-gray-300"
                                                            placeholder="Tell us what you liked or didn't like..."></textarea>
                                                    </div>

                                                    <!-- Actions -->
                                                    <div class="flex gap-3">
                                                        <button type="button" @click="showModal = false"
                                                            class="flex-1 px-6 py-3 border-2 border-gray-200 text-gray-700 rounded-xl font-bold hover:bg-gray-50 transition-colors">
                                                            Cancel
                                                        </button>
                                                        <button type="submit" :disabled="rating === 0"
                                                            :class="{'opacity-50 cursor-not-allowed': rating === 0}"
                                                            class="flex-1 px-6 py-3 bg-gradient-to-r from-[#1a1a1a] to-[#333] text-white rounded-xl font-bold hover:from-[#d4af37] hover:to-[#b5952f] transition-all">
                                                            Submit Review
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <!-- Previous Inquiries Section -->
                    @php
                        $orderInquiries = \App\Models\ProductInquiry::where('order_id', $order->id)->get();
                    @endphp
                    @if($orderInquiries->count() > 0)
                        <div class="px-6 py-4 bg-orange-50/50 border-t border-orange-100">
                            <div class="flex items-center gap-2 mb-3">
                                <i class="fas fa-history text-orange-500"></i>
                                <span class="text-xs font-bold text-gray-600 uppercase tracking-wider">Your Inquiries ({{ $orderInquiries->count() }})</span>
                            </div>
                            <div class="space-y-3">
                                @foreach($orderInquiries as $inquiry)
                                    <div x-data="{ showDetails: false }" class="bg-white rounded-xl p-4 border border-orange-100 shadow-sm">
                                        <div class="flex items-start justify-between gap-4">
                                            <div class="flex-1">
                                                <p class="text-sm text-gray-700 italic">"{{ Str::limit($inquiry->message, 80) }}"</p>
                                                <p class="text-[10px] text-gray-400 mt-1">
                                                    <i class="fas fa-calendar"></i> {{ $inquiry->created_at->format('M d, Y h:i A') }}
                                                </p>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                @php
                                                    $statusConfig = [
                                                        'pending' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'border' => 'border-amber-200', 'icon' => 'fa-clock'],
                                                        'processing' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-700', 'border' => 'border-blue-200', 'icon' => 'fa-spinner'],
                                                        'resolved' => ['bg' => 'bg-green-50', 'text' => 'text-green-700', 'border' => 'border-green-200', 'icon' => 'fa-check-circle'],
                                                    ];
                                                    $config = $statusConfig[$inquiry->status] ?? $statusConfig['pending'];
                                                @endphp
                                                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider border {{ $config['bg'] }} {{ $config['text'] }} {{ $config['border'] }}">
                                                    <i class="fas {{ $config['icon'] }}"></i>
                                                    {{ ucfirst($inquiry->status) }}
                                                </span>
                                                @if($inquiry->admin_reply)
                                                    <button @click="showDetails = !showDetails" class="text-xs text-[#d4af37] font-semibold hover:underline">
                                                        <i class="fas" :class="showDetails ? 'fa-chevron-up' : 'fa-chevron-down'"></i> View Reply
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <!-- Admin Reply -->
                                        @if($inquiry->admin_reply)
                                            <div x-show="showDetails" x-collapse class="mt-3 pt-3 border-t border-gray-100">
                                                <div class="bg-green-50 rounded-lg p-3 border border-green-100">
                                                    <p class="text-[10px] font-bold text-green-700 uppercase tracking-wider mb-1">
                                                        <i class="fas fa-reply"></i> Admin Response
                                                    </p>
                                                    <p class="text-sm text-gray-700">{{ $inquiry->admin_reply }}</p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Order Footer -->
                    <div class="bg-gray-50 px-6 py-4 flex justify-between items-center rounded-b-2xl border-t border-gray-100">
                        <!-- Report Issue Button -->
                        <div x-data="{ openInquiry: false }">
                            <button @click="openInquiry = true" class="inline-flex items-center gap-2 text-xs text-red-500 font-bold border border-red-200 px-4 py-2 rounded-full hover:bg-red-50 transition-all duration-300">
                                <i class="fas fa-exclamation-circle"></i> Report Issue / Inquiry
                            </button>

                            <div x-show="openInquiry" style="display: none;" 
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0"
                                 x-transition:enter-end="opacity-100"
                                 class="fixed inset-0 z-50 overflow-y-auto">
                                <div class="flex items-center justify-center min-h-screen px-4">
                                    <div class="fixed inset-0 bg-gray-900/80 backdrop-blur-sm" @click="openInquiry = false"></div>

                                    <div class="relative bg-white rounded-2xl shadow-2xl max-w-lg w-full p-8 border-t-4 border-red-500">
                                        <div class="flex items-center gap-4 mb-6">
                                            <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                                                <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                                            </div>
                                            <div>
                                                <h3 class="text-xl font-bold text-gray-900" style="font-family: 'Playfair Display', serif;">Report an Issue</h3>
                                                <p class="text-xs text-gray-500">Order #{{ $order->id }}</p>
                                            </div>
                                        </div>
                                        
                                        <form action="{{ route('inquiry.store') }}" method="POST" class="space-y-5">
                                            @csrf
                                            <input type="hidden" name="order_id" value="{{ $order->id }}">
                                            <input type="hidden" name="product_id" value="{{ $order->items->first()->product_id }}">

                                            <div>
                                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                                    <i class="fas fa-comment-alt text-red-500 mr-1"></i> Describe your issue
                                                </label>
                                                <textarea name="message" rows="4" 
                                                    class="w-full border-2 border-gray-200 rounded-xl focus:border-red-400 focus:ring-red-400 transition-all p-4" 
                                                    required placeholder="Damaged item, wrong size, missing items..."></textarea>
                                            </div>

                                            <div class="flex justify-end gap-3">
                                                <button type="button" @click="openInquiry = false" 
                                                    class="px-6 py-3 border-2 border-gray-200 text-gray-600 rounded-xl font-semibold hover:bg-gray-50 transition-colors">
                                                    Cancel
                                                </button>
                                                <button type="submit" 
                                                    class="inline-flex items-center gap-2 bg-gradient-to-r from-red-600 to-red-500 text-white px-6 py-3 rounded-xl font-bold uppercase text-sm tracking-widest hover:shadow-lg hover:shadow-red-500/30 transition-all duration-300">
                                                    <i class="fas fa-paper-plane"></i>
                                                    Submit Inquiry
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Status Actions -->
                        <div>
                            @if($order->status === 'shipped')
                                <form action="{{ route('orders.complete', $order->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center gap-2 bg-gradient-to-r from-green-600 to-green-500 text-white px-6 py-3 rounded-full font-bold text-sm uppercase tracking-wider hover:shadow-lg hover:shadow-green-500/30 transition-all duration-300 group">
                                        <i class="fas fa-check-circle group-hover:animate-pulse"></i>
                                        Confirm Delivery
                                    </button>
                                </form>
                            @elseif($order->status === 'completed')
                                <span class="inline-flex items-center gap-2 text-green-600 font-bold text-sm bg-green-50 px-4 py-2 rounded-full border border-green-100">
                                    <i class="fas fa-check-circle text-lg"></i>
                                    Received & Completed
                                </span>
                            @elseif($order->status === 'pending')
                                <span class="inline-flex items-center gap-2 text-amber-600 font-medium text-sm">
                                    <i class="fas fa-clock animate-pulse"></i>
                                    Awaiting shipment...
                                </span>
                            @elseif($order->status === 'cancelled')
                                <span class="inline-flex items-center gap-2 text-red-600 font-medium text-sm">
                                    <i class="fas fa-times-circle"></i>
                                    Order Cancelled
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <!-- Empty State -->
                <div class="text-center py-24 bg-white rounded-3xl shadow-sm border border-gray-100">
                    <div class="relative inline-block mb-8">
                        <div
                            class="w-32 h-32 bg-gradient-to-br from-gray-100 to-gray-50 rounded-full flex items-center justify-center">
                            <i class="fas fa-box-open text-5xl text-gray-300"></i>
                        </div>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-900 mb-3" style="font-family: 'Playfair Display', serif;">No
                        Orders Yet</h3>
                    <p class="text-gray-500 mb-8 max-w-md mx-auto">Start shopping to see your orders here!</p>
                    <a href="{{ route('dashboard') }}"
                        class="inline-flex items-center gap-3 bg-gradient-to-r from-[#1a1a1a] to-[#333] text-white px-10 py-4 rounded-full font-bold uppercase text-sm tracking-widest hover:from-[#d4af37] hover:to-[#b5952f] transition-all duration-300 shadow-lg">
                        <i class="fas fa-shopping-bag"></i>
                        <span>Start Shopping</span>
                    </a>
                </div>
            @endforelse

                <!-- Pagination -->
                @if($orders->hasPages())
                    <div class="mt-8 flex justify-center">
                        {{ $orders->links() }}
                    </div>
                @endif

            </div>
        </div>

        <!-- SweetAlert for notifications -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        @if(session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    Swal.fire({
                        icon: 'success',
                        title: 'Thank You!',
                        text: "{{ session('success') }}",
                        confirmButtonColor: '#d4af37',
                        confirmButtonText: 'Great!',
                        background: '#fff',
                        iconColor: '#d4af37'
                    });
                });
            </script>
        @endif

        @if(session('error'))
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: "{{ session('error') }}",
                        confirmButtonColor: '#1a1a1a',
                        confirmButtonText: 'Okay'
                    });
                });
            </script>
        @endif
</x-app-layout>