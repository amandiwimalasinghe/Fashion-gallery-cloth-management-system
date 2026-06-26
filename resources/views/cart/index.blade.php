<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div
                class="w-12 h-12 bg-gradient-to-br from-[#d4af37] to-[#e5c76b] rounded-xl flex items-center justify-center shadow-lg shadow-[#d4af37]/20">
                <i class="fas fa-shopping-bag text-white text-lg"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-900" style="font-family: 'Playfair Display', serif;">
                    {{ __('My Shopping Bag') }}
                </h2>
                <p class="text-sm text-gray-500">Review your items before checkout</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-b from-gray-50 to-white min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if($cartItems->count() > 0)
                <div class="flex flex-col lg:flex-row gap-8">

                    <!-- Cart Items -->
                    <div class="flex-1">
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                            <!-- Table Header -->
                            <div
                                class="bg-gray-50 px-6 py-4 border-b border-gray-100 hidden md:grid grid-cols-12 gap-4 text-xs font-bold text-gray-400 uppercase tracking-wider">
                                <div class="col-span-5">Product</div>
                                <div class="col-span-2 text-center">Price</div>
                                <div class="col-span-2 text-center">Quantity</div>
                                <div class="col-span-2 text-right">Total</div>
                                <div class="col-span-1 text-center"></div>
                            </div>

                            <!-- Cart Items List -->
                            <div class="divide-y divide-gray-100">
                                @foreach($cartItems as $item)
                                    <div class="p-6 hover:bg-gray-50/50 transition-colors group">
                                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                                            <!-- Product Info -->
                                            <div class="md:col-span-5 flex items-center gap-4">
                                                <div
                                                    class="h-24 w-24 shrink-0 overflow-hidden rounded-xl border border-gray-200 bg-gray-100 group-hover:border-[#d4af37]/30 transition-colors">
                                                    <img src="{{ asset('storage/' . $item->product->image) }}"
                                                        class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-500">
                                                </div>
                                                <div>
                                                    <h4 class="font-bold text-gray-900 text-lg"
                                                        style="font-family: 'Playfair Display', serif;">
                                                        {{ $item->product->name }}</h4>
                                                    <p class="text-xs text-gray-500 mt-1 flex items-center gap-2 flex-wrap">
                                                        <span
                                                            class="bg-gray-100 px-2 py-0.5 rounded-full">{{ $item->product->category }}</span>
                                                        @if($item->product->size)
                                                            <span class="bg-gray-100 px-2 py-0.5 rounded-full">Size:
                                                                {{ $item->product->size }}</span>
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>

                                            <!-- Price -->
                                            <div class="md:col-span-2 text-center">
                                                <span class="md:hidden text-xs text-gray-400 block mb-1">Price</span>
                                                <span class="text-gray-700 font-medium">Rs.
                                                    {{ number_format($item->product->price, 2) }}</span>
                                            </div>

                                            <!-- Quantity -->
                                            <div class="md:col-span-2 text-center">
                                                <span class="md:hidden text-xs text-gray-400 block mb-1">Quantity</span>
                                                <span
                                                    class="inline-flex items-center justify-center bg-gradient-to-r from-gray-100 to-gray-50 px-5 py-2 rounded-full font-bold text-gray-800 border border-gray-200">
                                                    {{ $item->quantity }}
                                                </span>
                                            </div>

                                            <!-- Total -->
                                            <div class="md:col-span-2 text-right">
                                                <span class="md:hidden text-xs text-gray-400 block mb-1">Total</span>
                                                <span class="text-xl font-bold text-[#d4af37]">
                                                    Rs. {{ number_format($item->product->price * $item->quantity, 2) }}
                                                </span>
                                            </div>

                                            <!-- Remove Button -->
                                            <div class="md:col-span-1 text-center">
                                                <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="w-10 h-10 rounded-full bg-gray-100 text-gray-400 hover:bg-red-500 hover:text-white transition-all duration-300 flex items-center justify-center mx-auto group/btn"
                                                        title="Remove Item">
                                                        <i class="fas fa-trash-alt text-sm group-hover/btn:animate-pulse"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Continue Shopping -->
                        <a href="{{ route('dashboard') }}"
                            class="inline-flex items-center gap-2 text-gray-500 hover:text-[#d4af37] transition-colors mt-6 font-medium">
                            <i class="fas fa-arrow-left"></i>
                            <span>Continue Shopping</span>
                        </a>
                    </div>

                    <!-- Order Summary -->
                    <div class="w-full lg:w-96">
                        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 sticky top-28">
                            <!-- Header -->
                            <div class="flex items-center gap-3 mb-6 pb-6 border-b border-gray-100">
                                <div
                                    class="w-10 h-10 bg-gradient-to-br from-[#d4af37] to-[#e5c76b] rounded-lg flex items-center justify-center">
                                    <i class="fas fa-receipt text-white"></i>
                                </div>
                                <h3 class="font-bold text-xl text-gray-900" style="font-family: 'Playfair Display', serif;">
                                    Order Summary</h3>
                            </div>

                            <!-- Summary Details -->
                            <div class="space-y-4 mb-6">
                                <div class="flex justify-between text-gray-600">
                                    <span>Subtotal ({{ $cartItems->sum('quantity') }} items)</span>
                                    <span class="font-medium">Rs. {{ number_format($subtotal, 2) }}</span>
                                </div>
                                
                            </div>

                            <!-- Total -->
                            <div class="border-t border-dashed border-gray-200 pt-6 mb-8">
                                <div class="flex justify-between items-end">
                                    <span class="text-lg font-bold text-gray-900">Total</span>
                                    <div class="text-right">
                                        <span
                                            class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-[#d4af37] to-[#b5952f]">
                                            Rs. {{ number_format($total, 2) }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Checkout Button -->
                            <form action="{{ route('checkout.process') }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-full bg-gradient-to-r from-[#1a1a1a] to-[#333] text-white py-4 rounded-xl font-bold uppercase text-sm tracking-widest hover:from-[#d4af37] hover:to-[#b5952f] transition-all duration-300 shadow-lg hover:shadow-[#d4af37]/30 flex justify-center items-center gap-3 group">
                                    <span>Proceed to Checkout</span>
                                    <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                                </button>
                            </form>

                            <!-- Trust Badges -->
                            <div class="flex items-center justify-center gap-4 mt-6 text-gray-400 text-xs">
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-lock text-green-500"></i> Secure
                                </span>
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-shield-alt text-blue-500"></i> Protected
                                </span>
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-truck text-[#d4af37]"></i> Free Shipping
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

            @else
                <!-- Empty Cart State -->
                <div class="text-center py-24 bg-white rounded-3xl shadow-sm border border-gray-100">
                    <div class="relative inline-block mb-8">
                        <div
                            class="w-32 h-32 bg-gradient-to-br from-gray-100 to-gray-50 rounded-full flex items-center justify-center">
                            <i class="fas fa-shopping-bag text-5xl text-gray-300"></i>
                        </div>
                        <div
                            class="absolute -bottom-2 -right-2 w-12 h-12 bg-[#d4af37] rounded-full flex items-center justify-center text-white shadow-lg">
                            <i class="fas fa-times"></i>
                        </div>
                    </div>

                    <h3 class="text-3xl font-bold text-gray-900 mb-3" style="font-family: 'Playfair Display', serif;">Your
                        bag is empty</h3>
                    <p class="text-gray-500 mb-8 max-w-md mx-auto">Looks like you haven't added anything to your bag yet.
                        Start exploring our amazing collection!</p>

                    <a href="{{ route('dashboard') }}"
                        class="inline-flex items-center gap-3 bg-gradient-to-r from-[#1a1a1a] to-[#333] text-white px-10 py-4 rounded-full font-bold uppercase text-sm tracking-widest hover:from-[#d4af37] hover:to-[#b5952f] transition-all duration-300 shadow-lg hover:shadow-[#d4af37]/30 group">
                        <i class="fas fa-shopping-bag"></i>
                        <span>Start Shopping</span>
                        <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>