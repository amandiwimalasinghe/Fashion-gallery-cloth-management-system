<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div
                class="w-12 h-12 bg-gradient-to-br from-yellow-400 to-amber-500 rounded-xl flex items-center justify-center shadow-lg shadow-yellow-500/20">
                <i class="fas fa-star text-white text-lg"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-900" style="font-family: 'Playfair Display', serif;">
                    {{ __('Customer Feedback') }}
                </h2>
                <p class="text-sm text-gray-500">See what customers think about your designs</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-b from-gray-50 to-white min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Stats Card -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                <div
                    class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4 hover:shadow-lg transition-shadow">
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-yellow-400 to-amber-500 rounded-xl flex items-center justify-center shadow-md">
                        <i class="fas fa-star text-white text-xl"></i>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-gray-900">{{ $reviews->total() }}</div>
                        <div class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Total Reviews</div>
                    </div>
                </div>
            </div>

            @if($reviews->count() > 0)
                <!-- Reviews Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($reviews as $review)
                        <div
                            class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl hover:border-[#d4af37]/30 transition-all duration-300 group">

                            <!-- Header -->
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-12 h-12 rounded-xl bg-gradient-to-br from-gray-100 to-gray-50 flex items-center justify-center text-gray-500 font-bold text-lg border border-gray-200">
                                        {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-900">{{ $review->user->name }}</h4>
                                        <p class="text-xs text-gray-400 flex items-center gap-1">
                                            <i class="fas fa-clock text-[10px]"></i>
                                            {{ $review->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Star Rating -->
                                <div class="flex gap-0.5">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i
                                            class="fas fa-star text-sm {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-200' }}"></i>
                                    @endfor
                                </div>
                            </div>

                            <!-- Review Text -->
                            <p
                                class="text-gray-600 text-sm mb-5 leading-relaxed italic bg-gray-50 p-4 rounded-xl border-l-4 border-[#d4af37]">
                                "{{ $review->comment ?? 'No comment provided.' }}"
                            </p>

                            <!-- Product Info -->
                            <div
                                class="flex items-center gap-3 bg-gray-50 p-3 rounded-xl border border-gray-100 group-hover:border-[#d4af37]/30 transition-colors">
                                <img src="{{ asset('storage/' . $review->product->image) }}"
                                    class="w-14 h-14 object-cover rounded-lg shadow-sm">
                                <div>
                                    <h5 class="font-bold text-gray-800 text-sm group-hover:text-[#d4af37] transition-colors">
                                        {{ $review->product->name }}</h5>
                                    <p class="text-[10px] text-gray-400 uppercase tracking-wider">Product
                                        #{{ $review->product->id }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-10 flex justify-center">
                    {{ $reviews->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-24 bg-white rounded-3xl shadow-sm border border-gray-100">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-comment-slash text-gray-300 text-4xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2" style="font-family: 'Playfair Display', serif;">No
                        Reviews Yet</h3>
                    <p class="text-gray-500 max-w-md mx-auto">Wait for customers to purchase and review your designs. Their
                        feedback will appear here.</p>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>