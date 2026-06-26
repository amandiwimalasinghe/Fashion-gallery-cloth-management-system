<x-app-layout>
    <!-- Hero Banner Section -->
    <div class="relative h-80 md:h-96 overflow-hidden">
        <div class="absolute inset-0">
            @if($designer->banner_image)
                <img src="{{ asset('storage/' . $designer->banner_image) }}" class="w-full h-full object-cover">
            @else
                <img src="https://images.unsplash.com/photo-1558171813-4c088753af8f?q=80&w=2187&auto=format&fit=crop" class="w-full h-full object-cover">
            @endif
        </div>
        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-black/20"></div>
        
        <!-- Edit Banner Button (For Owner) -->
        @auth
            @if(Auth::id() === $designer->id)
                <form action="{{ route('designer.banner.update') }}" method="POST" enctype="multipart/form-data" class="absolute top-4 right-4 z-20">
                    @csrf
                    <label class="inline-flex items-center gap-2 bg-white/90 backdrop-blur-sm text-gray-700 px-5 py-2.5 rounded-full font-semibold text-sm cursor-pointer hover:bg-white transition-all duration-300 shadow-lg group">
                        <i class="fas fa-camera text-[#d4af37] group-hover:rotate-12 transition-transform"></i>
                        <span>Edit Banner</span>
                        <input type="file" name="banner_image" class="hidden" accept="image/*" onchange="this.form.submit()">
                    </label>
                </form>
            @endif
        @endauth

        <!-- Designer Profile Card -->
        <div class="absolute bottom-0 left-0 right-0 p-6 md:p-8">
            <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-end md:items-center gap-6">
                <!-- Profile Image -->
                <div class="relative">
                    <div class="w-28 h-28 md:w-36 md:h-36 rounded-2xl overflow-hidden border-4 border-white shadow-2xl bg-gray-100">
                        @if($designer->profile_image)
                            <img src="{{ asset('storage/' . $designer->profile_image) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-[#d4af37] to-[#b5952f] flex items-center justify-center text-white text-5xl font-bold" style="font-family: 'Playfair Display', serif;">
                                {{ strtoupper(substr($designer->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    <div class="absolute -bottom-2 -right-2 w-10 h-10 bg-gradient-to-br from-[#d4af37] to-[#e5c76b] rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-palette text-white"></i>
                    </div>
                </div>

                <!-- Designer Info -->
                <div class="flex-1 text-white">
                    <div class="flex flex-col md:flex-row md:items-center gap-2 md:gap-4 mb-2">
                        <h1 class="text-3xl md:text-4xl font-bold" style="font-family: 'Playfair Display', serif;">
                            {{ $designer->company_name ?? $designer->name }}
                        </h1>
                        <span class="inline-flex items-center gap-1 bg-gradient-to-r from-[#d4af37] to-[#e5c76b] text-white text-xs font-bold px-3 py-1 rounded-full shadow-md w-fit">
                            <i class="fas fa-check-circle"></i>
                            Verified Designer
                        </span>
                    </div>
                    <div class="flex flex-wrap items-center gap-4 text-sm text-gray-300">
                        <span class="flex items-center gap-1">
                            <i class="fas fa-map-marker-alt text-[#d4af37]"></i>
                            {{ $designer->address ?? 'Sri Lanka' }}
                        </span>
                        <span class="flex items-center gap-1">
                            <i class="fas fa-paint-brush text-[#d4af37]"></i>
                            {{ $designer->products->count() }} Designs
                        </span>
                        @php
                            // Get all product IDs for this designer
                            $productIds = $designer->products->pluck('id');
                            // Get average rating from reviews table for these products
                            $avgRating = \App\Models\Review::whereIn('product_id', $productIds)->avg('rating');
                            $reviewCount = \App\Models\Review::whereIn('product_id', $productIds)->count();
                        @endphp
                        <span class="flex items-center gap-1">
                            <i class="fas fa-star text-yellow-400"></i>
                            @if($reviewCount > 0)
                                {{ number_format($avgRating, 1) }} <span class="text-gray-400 text-xs">({{ $reviewCount }} reviews)</span>
                            @else
                                <span class="text-gray-400 text-xs">No reviews yet</span>
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons (For Designer Owner) -->
    @auth
        @if(Auth::id() === $designer->id)
            <div class="bg-gradient-to-r from-gray-50 to-white border-b border-gray-100">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                    <div class="flex flex-wrap items-center gap-3">
                        <a href="{{ route('products.create') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-[#d4af37] to-[#e5c76b] text-white px-6 py-3 rounded-full font-bold text-sm uppercase tracking-wider hover:shadow-lg hover:shadow-[#d4af37]/30 transition-all duration-300 group">
                            <i class="fas fa-plus group-hover:rotate-90 transition-transform"></i>
                            <span>New Design</span>
                        </a>
                        <a href="{{ route('designer.orders', $designer->id) }}" class="inline-flex items-center gap-2 bg-white border-2 border-gray-200 text-gray-700 px-6 py-3 rounded-full font-semibold text-sm hover:border-[#d4af37] hover:text-[#d4af37] transition-all duration-300">
                            <i class="fas fa-box-open"></i>
                            <span>Manage Orders</span>
                        </a>
                        <a href="{{ route('designer.reviews', $designer->id) }}" class="inline-flex items-center gap-2 bg-white border-2 border-gray-200 text-gray-700 px-6 py-3 rounded-full font-semibold text-sm hover:border-[#d4af37] hover:text-[#d4af37] transition-all duration-300">
                            <i class="fas fa-star"></i>
                            <span>View Feedback</span>
                        </a>
                    </div>
                </div>
            </div>
        @endif
    @endauth

    <!-- Products Grid Section -->
    <div class="py-12 bg-gradient-to-b from-white to-gray-50 min-h-[50vh]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Section Header -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                <div>
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-900" style="font-family: 'Playfair Display', serif;">
                        Design Collection
                    </h2>
                    <p class="text-gray-500 mt-1">Explore {{ $designer->products->count() }} unique designs</p>
                </div>
            </div>

            @if($designer->products->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                    @foreach($designer->products as $index => $product)
                        <div class="group bg-white rounded-2xl shadow-sm hover:shadow-2xl transition-all duration-500 ease-out overflow-hidden border border-gray-100 hover:border-[#d4af37]/30 animate-fadeInUp" style="animation-delay: {{ $index * 100 }}ms;">

                            <!-- Product Image -->
                            <div class="relative h-72 overflow-hidden">
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover transition-all duration-700 group-hover:scale-110">

                                <!-- Category Badge -->
                                <span class="absolute top-4 left-4 bg-white/95 backdrop-blur-sm text-[10px] font-bold px-3 py-1.5 uppercase tracking-widest shadow-lg rounded-full flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-[#d4af37]"></span>
                                    {{ $product->category }}
                                </span>

                                <!-- Quick Actions Overlay (For Designer) -->
                                @auth
                                    @if(Auth::id() === $designer->id)
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-end justify-center p-5">
                                            <div class="flex gap-3">
                                                <a href="{{ route('products.edit', $product->id) }}" class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-[#d4af37] hover:bg-[#d4af37] hover:text-white transition-all duration-300 shadow-lg transform translate-y-4 group-hover:translate-y-0 opacity-0 group-hover:opacity-100" style="transition-delay: 100ms;">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button onclick="confirmDelete({{ $product->id }})" class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-red-500 hover:bg-red-500 hover:text-white transition-all duration-300 shadow-lg transform translate-y-4 group-hover:translate-y-0 opacity-0 group-hover:opacity-100" style="transition-delay: 150ms;">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endif
                                @endauth
                            </div>

                            <!-- Product Info -->
                            <div class="p-5">
                                <h3 class="font-bold text-gray-900 text-lg mb-2 group-hover:text-[#d4af37] transition-colors" style="font-family: 'Playfair Display', serif;">
                                    {{ $product->name }}
                                </h3>
                                <div class="flex justify-between items-end border-t border-gray-100 pt-3 mt-2">
                                    <div>
                                        <span class="text-xs text-gray-400 block">Price</span>
                                        <span class="text-xl font-bold text-[#1a1a1a]">Rs. {{ number_format($product->price, 2) }}</span>
                                    </div>
                                    @if($product->stock_quantity > 0)
                                        <span class="text-[10px] text-green-600 bg-green-50 px-3 py-1.5 rounded-full font-bold border border-green-100 flex items-center gap-1">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                                            {{ $product->stock_quantity }} left
                                        </span>
                                    @else
                                        <span class="text-[10px] text-red-600 bg-red-50 px-3 py-1.5 rounded-full font-bold border border-red-100">
                                            Sold Out
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Hidden Delete Form -->
                            <form id="delete-form-{{ $product->id }}" action="{{ route('products.destroy', $product->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-20 bg-white rounded-3xl shadow-sm border border-gray-100">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-paint-brush text-gray-300 text-4xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2" style="font-family: 'Playfair Display', serif;">No Designs Yet</h3>
                    <p class="text-gray-500 mb-6">
                        @if(Auth::check() && Auth::id() === $designer->id)
                            Start creating your first design!
                        @else
                            This designer hasn't uploaded any designs yet.
                        @endif
                    </p>
                    @auth
                        @if(Auth::id() === $designer->id)
                            <a href="{{ route('products.create') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-[#d4af37] to-[#e5c76b] text-white px-8 py-4 rounded-full font-bold uppercase tracking-widest text-sm hover:shadow-lg hover:shadow-[#d4af37]/30 transition-all duration-300">
                                <i class="fas fa-plus"></i>
                                <span>Create First Design</span>
                            </a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
    </div>

    <!-- SweetAlert for Delete Confirmation -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(productId) {
            Swal.fire({
                title: 'Delete Design?',
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: '<i class="fas fa-trash mr-2"></i>Yes, delete it!',
                cancelButtonText: 'Cancel',
                background: '#fff',
                customClass: {
                    popup: 'rounded-2xl',
                    confirmButton: 'rounded-full px-6 py-3 font-bold uppercase text-sm tracking-wider',
                    cancelButton: 'rounded-full px-6 py-3 font-bold uppercase text-sm tracking-wider'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + productId).submit();
                }
            });
        }
    </script>

    <style>
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeInUp { animation: fadeInUp 0.6s ease-out forwards; }
    </style>
</x-app-layout>
