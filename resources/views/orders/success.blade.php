<x-app-layout>
    <div class="py-16 bg-gradient-to-b from-gray-50 to-white min-h-screen flex items-center justify-center">
        <div class="max-w-xl w-full mx-auto px-4">
            <div
                class="bg-white p-12 rounded-3xl shadow-2xl text-center border border-gray-100 relative overflow-hidden">

                <!-- Decorative Elements -->
                <div
                    class="absolute top-0 left-0 w-32 h-32 bg-gradient-to-br from-green-400/10 to-transparent rounded-full -translate-x-1/2 -translate-y-1/2">
                </div>
                <div
                    class="absolute bottom-0 right-0 w-40 h-40 bg-gradient-to-tl from-[#d4af37]/10 to-transparent rounded-full translate-x-1/2 translate-y-1/2">
                </div>

                <!-- Success Icon -->
                <div class="relative mb-8">
                    <div class="w-28 h-28 mx-auto relative">
                        <!-- Outer Ring Animation -->
                        <div class="absolute inset-0 bg-green-100 rounded-full animate-ping opacity-30"></div>
                        <!-- Inner Circle -->
                        <div
                            class="absolute inset-2 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center shadow-lg shadow-green-500/30">
                            <i class="fas fa-check text-5xl text-white animate-bounce"></i>
                        </div>
                    </div>
                </div>

                <!-- Title -->
                <h1 class="text-4xl font-bold text-gray-900 mb-4" style="font-family: 'Playfair Display', serif;">
                    Order Confirmed!
                </h1>

                <!-- Subtitle -->
                <p class="text-gray-500 mb-8 text-lg">
                    Thank you for your purchase! Your order has been received and is being processed by our talented
                    designers.
                </p>

                <!-- Order Info Badge -->
                <div
                    class="inline-flex items-center gap-3 bg-gray-50 px-6 py-3 rounded-2xl border border-gray-200 mb-10">
                    <div
                        class="w-10 h-10 bg-gradient-to-br from-[#d4af37] to-[#e5c76b] rounded-full flex items-center justify-center">
                        <i class="fas fa-truck text-white"></i>
                    </div>
                    <div class="text-left">
                        <span class="text-xs text-gray-400 block">Estimated Delivery</span>
                        <span class="font-bold text-gray-800">3-5 Business Days</span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('dashboard') }}"
                        class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-[#1a1a1a] to-[#333] text-white px-8 py-4 rounded-full font-bold uppercase text-sm tracking-widest hover:from-[#d4af37] hover:to-[#b5952f] transition-all duration-300 shadow-lg hover:shadow-[#d4af37]/30 group">
                        <i class="fas fa-shopping-bag"></i>
                        <span>Continue Shopping</span>
                        <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                    </a>
                    <a href="{{ route('orders.index') }}"
                        class="inline-flex items-center justify-center gap-2 bg-white border-2 border-gray-200 text-gray-700 px-8 py-4 rounded-full font-bold uppercase text-sm tracking-widest hover:border-[#d4af37] hover:text-[#d4af37] transition-all duration-300">
                        <i class="fas fa-box"></i>
                        <span>View My Orders</span>
                    </a>
                </div>

                <!-- Trust Badges -->
                <div
                    class="flex items-center justify-center gap-6 mt-10 text-gray-400 text-xs pt-8 border-t border-gray-100">
                    <span class="flex items-center gap-2">
                        <i class="fas fa-shield-alt text-green-500"></i> Secure Payment
                    </span>
                    <span class="flex items-center gap-2">
                        <i class="fas fa-truck text-[#d4af37]"></i> Free Shipping
                    </span>
                    <span class="flex items-center gap-2">
                        <i class="fas fa-undo text-blue-500"></i> Easy Returns
                    </span>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>