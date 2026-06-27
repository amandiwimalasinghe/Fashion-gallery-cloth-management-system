<x-app-layout>
    <!-- Hero Section with Parallax Effect -->
    <div class="relative h-[450px] w-full overflow-hidden bg-gray-900">
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1490481651871-ab68de25d43d?q=80&w=2070&auto=format&fit=crop"
                 alt="Fashion Hero"
                 class="w-full h-full object-cover opacity-50 transform scale-105 hover:scale-110 transition-transform duration-[3000ms]">
        </div>

        <!-- Gradient Overlays -->
        <div class="absolute inset-0 bg-gradient-to-r from-black/90 via-black/50 to-transparent z-10"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent z-10"></div>

        <!-- Hero Content -->
        <div class="relative z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex flex-col justify-center">
            <div class="max-w-2xl">
                <span class="inline-block px-4 py-1.5 bg-[#d4af37]/20 border border-[#d4af37]/30 text-[#d4af37] text-xs font-bold uppercase tracking-widest rounded-full mb-6 animate-fadeIn">
                    <i class="fas fa-sparkles mr-2"></i>Premium Collection
                </span>

                <h1 class="text-4xl md:text-6xl font-bold text-white mb-4 leading-tight animate-fadeInUp"
                    style="font-family: 'Playfair Display', serif; animation-delay: 0.1s;">
                    Elevate Your <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#d4af37] to-[#e5c76b]">Style</span>
                </h1>

                <p class="text-gray-300 text-lg md:text-xl max-w-xl font-light mb-8 animate-fadeInUp" style="animation-delay: 0.2s;">
                    Curated collections from the world's most promising designers. Experience luxury in every thread.
                </p>

                <div class="flex flex-wrap gap-4 animate-fadeInUp" style="animation-delay: 0.3s;">
                    <a href="#collection" class="group inline-flex items-center gap-2 bg-gradient-to-r from-[#d4af37] to-[#e5c76b] text-white px-8 py-4 rounded-full font-bold uppercase tracking-widest text-sm hover:shadow-2xl hover:shadow-[#d4af37]/30 transition-all duration-300 transform hover:-translate-y-1">
                        <span>Shop Now</span>
                        <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                    </a>
                    
                </div>
            </div>
        </div>

        <!-- Scroll Indicator -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 z-20 animate-bounce">
            <a href="#collection" class="text-white/60 hover:text-white transition-colors">
                <i class="fas fa-chevron-down text-2xl"></i>
            </a>
        </div>
    </div>

    <!-- Filter Section with Glassmorphism -->
    <div class="sticky top-20 z-30 bg-white/95 backdrop-blur-lg border-b border-gray-200 shadow-sm transition-all duration-300" id="collection">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5">

            <form method="GET" action="{{ route('dashboard') }}" class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">

                <!-- Filter Options -->
                <div class="flex flex-wrap items-center gap-3">
                    <span class="text-sm font-bold text-gray-400 uppercase tracking-wider flex items-center gap-2">
                        <i class="fas fa-sliders-h text-[#d4af37]"></i>
                        <span class="hidden sm:inline">Filters:</span>
                    </span>

                    <select name="category" onchange="this.form.submit()"
                            class="border-gray-200 bg-gray-50 rounded-full text-sm focus:border-[#d4af37] focus:ring-[#d4af37] py-2.5 px-4 cursor-pointer hover:bg-gray-100 transition-colors font-medium">
                        <option value="">All Categories</option>
                        <option value="Men" {{ request('category') == 'Men' ? 'selected' : '' }}>Men</option>
                        <option value="Women" {{ request('category') == 'Women' ? 'selected' : '' }}>Women</option>
                        <option value="Kids" {{ request('category') == 'Kids' ? 'selected' : '' }}>Kids</option>
                        <option value="Accessories" {{ request('category') == 'Accessories' ? 'selected' : '' }}>Accessories</option>
                    </select>

                    <select name="size" onchange="this.form.submit()"
                            class="border-gray-200 bg-gray-50 rounded-full text-sm focus:border-[#d4af37] focus:ring-[#d4af37] py-2.5 px-4 cursor-pointer hover:bg-gray-100 transition-colors font-medium">
                        <option value="">Any Size</option>
                        <option value="S" {{ request('size') == 'S' ? 'selected' : '' }}>Small (S)</option>
                        <option value="M" {{ request('size') == 'M' ? 'selected' : '' }}>Medium (M)</option>
                        <option value="L" {{ request('size') == 'L' ? 'selected' : '' }}>Large (L)</option>
                        <option value="XL" {{ request('size') == 'XL' ? 'selected' : '' }}>Extra Large (XL)</option>
                    </select>

                    <!-- Price Range -->
                    <div class="flex items-center gap-2 bg-gray-50 py-2 px-4 rounded-full border border-gray-200">
                        <i class="fas fa-tag text-gray-400 text-sm"></i>
                        <input type="number" name="min_price" placeholder="Min" value="{{ request('min_price') }}"
                               class="w-16 text-sm border-none bg-transparent focus:ring-0 p-0 placeholder-gray-400" min="0">
                        <span class="text-gray-300">—</span>
                        <input type="number" name="max_price" placeholder="Max" value="{{ request('max_price') }}"
                               class="w-16 text-sm border-none bg-transparent focus:ring-0 p-0 placeholder-gray-400" min="0">
                        <button type="submit" class="bg-gray-200 hover:bg-[#d4af37] hover:text-white w-7 h-7 rounded-full flex items-center justify-center transition-all duration-300">
                            <i class="fas fa-chevron-right text-xs"></i>
                        </button>
                    </div>
                </div>

                <!-- Sort & Clear -->
                <div class="flex items-center gap-4">
                    @if(request()->hasAny(['category', 'size', 'min_price', 'max_price', 'sort']))
                        <a href="{{ route('dashboard') }}" class="text-xs text-red-500 hover:text-red-700 font-bold uppercase flex items-center gap-1 transition-colors">
                            <i class="fas fa-times"></i>
                            Clear All
                        </a>
                    @endif

                    <select name="sort" onchange="this.form.submit()"
                            class="border-none bg-transparent font-bold text-sm focus:ring-0 cursor-pointer text-gray-700">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest Arrivals</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low → High</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High → Low</option>
                    </select>
                </div>
            </form>
        </div>
    </div>

    <!-- Products Grid Section -->
    <div class="py-16 bg-gradient-to-b from-gray-50 to-white min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Section Header -->
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-3" style="font-family: 'Playfair Display', serif;">
                    Discover Our <span class="text-[#d4af37]">Collection</span>
                </h2>
                <p class="text-gray-500 max-w-2xl mx-auto">
                    Handpicked designs from talented creators. Each piece tells a unique story.
                </p>
            </div>

            @if($products->count() > 0)
                <!-- Products Grid with Stagger Animation -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8 stagger-animation">
                    @foreach($products as $index => $product)
                        <div class="group bg-white rounded-2xl shadow-sm hover:shadow-2xl transition-all duration-500 ease-out flex flex-col h-full relative overflow-hidden border border-gray-100 hover:border-[#d4af37]/30 animate-fadeInUp"
                             style="animation-delay: {{ $index * 100 }}ms;">

                            <!-- Product Image Container -->
                            <div class="relative h-[340px] w-full bg-gray-100 overflow-hidden">
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                     class="w-full h-full object-cover transition-all duration-700 group-hover:scale-110">

                                <!-- Category Badge -->
                                <span class="absolute top-4 left-4 bg-white/95 backdrop-blur-sm text-[10px] font-bold px-3 py-1.5 uppercase tracking-widest shadow-lg rounded-full flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-[#d4af37]"></span>
                                    {{ $product->category }}
                                </span>

                                <!-- Quick Add Overlay -->
                                <div class="absolute inset-x-0 bottom-0 p-5 bg-gradient-to-t from-black/90 via-black/50 to-transparent translate-y-full group-hover:translate-y-0 transition-all duration-500 flex flex-col justify-end gap-2">
                                    @if($product->stock_quantity > 0)
                                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="w-full">
                                        @csrf
                                        <button type="submit" class="w-full bg-gradient-to-r from-[#d4af37] to-[#e5c76b] text-white py-3.5 rounded-xl font-bold text-sm uppercase tracking-wider hover:from-white hover:to-white hover:text-[#1a1a1a] transition-all duration-300 shadow-xl flex items-center justify-center gap-2 transform hover:scale-[1.02]">
                                            <i class="fas fa-shopping-bag"></i>
                                            <span>Add to Cart</span>
                                        </button>
                                    </form>
                                    @else
                                        <button disabled class="w-full bg-gray-600 text-white py-3.5 rounded-xl font-bold text-sm uppercase tracking-wider cursor-not-allowed opacity-80">
                                            <i class="fas fa-times-circle mr-2"></i>Sold Out
                                        </button>
                                    @endif
                                    
                                    <div class="flex gap-2">
                                        <a href="{{ route('TryOn', ['product_id' => $product->id]) }}" class="flex-1 bg-white/20 backdrop-blur-md border border-white/50 text-white py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider hover:bg-white hover:text-[#1a1a1a] transition-all duration-300 shadow-xl flex items-center justify-center gap-1.5 transform hover:scale-[1.02]">
                                            <i class="fas fa-magic"></i>
                                            <span>Try On</span>
                                        </a>
                                        <a href="{{ route('customizer.index', ['product_id' => $product->id]) }}" class="flex-1 bg-white/20 backdrop-blur-md border border-white/50 text-white py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider hover:bg-white hover:text-[#1a1a1a] transition-all duration-300 shadow-xl flex items-center justify-center gap-1.5 transform hover:scale-[1.02]">
                                            <i class="fas fa-paint-brush"></i>
                                            <span>Customize</span>
                                        </a>
                                    </div>
                                </div>

                                <!-- Wishlist Button -->
                                <button class="absolute top-4 right-4 w-10 h-10 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center text-gray-400 hover:text-red-500 hover:scale-110 transition-all duration-300 opacity-0 group-hover:opacity-100 shadow-lg">
                                    <i class="far fa-heart"></i>
                                </button>
                            </div>

                            <!-- Product Info -->
                            <div class="p-5 flex-1 flex flex-col">
                                <!-- Designer Link -->
                                <a href="{{ route('designer.show', $product->user->id) }}" class="text-xs text-gray-400 hover:text-[#d4af37] mb-2 flex items-center gap-1.5 transition-colors group/designer">
                                    <i class="fas fa-palette text-[10px] group-hover/designer:rotate-12 transition-transform"></i>
                                    <span>{{ $product->user->company_name ?? $product->user->name }}</span>
                                </a>

                                <!-- Product Name -->
                                <h3 class="font-bold text-gray-900 text-lg mb-2 leading-snug group-hover:text-[#d4af37] transition-colors" style="font-family: 'Playfair Display', serif;">
                                    {{ $product->name }}
                                </h3>

                                <!-- Price & Stock -->
                                <div class="mt-auto flex justify-between items-end border-t border-gray-100 pt-4">
                                    <div>
                                        <span class="text-xs text-gray-400 block">Price</span>
                                        <span class="text-xl font-bold text-[#1a1a1a]">
                                            Rs. {{ number_format($product->price, 2) }}
                                        </span>
                                    </div>

                                    @if($product->stock_quantity > 0)
                                        <span class="text-[10px] text-green-600 bg-green-50 px-3 py-1.5 rounded-full font-bold border border-green-100 flex items-center gap-1">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                                            In Stock
                                        </span>
                                    @else
                                        <span class="text-[10px] text-red-600 bg-red-50 px-3 py-1.5 rounded-full font-bold border border-red-100">
                                            Sold Out
                                        </span>
                                    @endif
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-16 flex justify-center">
                    <div class="inline-flex items-center gap-2 bg-white px-6 py-4 rounded-2xl shadow-sm border border-gray-100">
                        {{ $products->links() }}
                    </div>
                </div>

            @else
                <!-- Empty State -->
                <div class="text-center py-24 bg-white rounded-3xl shadow-sm border border-gray-100">
                    <div class="inline-flex items-center justify-center w-24 h-24 bg-gray-50 rounded-full mb-6">
                        <i class="fas fa-filter text-gray-300 text-4xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3" style="font-family: 'Playfair Display', serif;">No matches found</h3>
                    <p class="text-gray-500 max-w-md mx-auto mb-8">We couldn't find any designs matching your current filters. Try adjusting your search criteria.</p>
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 bg-[#1a1a1a] text-white px-8 py-4 rounded-full font-bold uppercase text-sm tracking-widest hover:bg-[#d4af37] transition-all duration-300 shadow-lg">
                        <i class="fas fa-refresh"></i>
                        Reset All Filters
                    </a>
                </div>
            @endif

        </div>
    </div>

    <style>
        /* Stagger animation delays */
        .stagger-animation > *:nth-child(1) { animation-delay: 0ms; }
        .stagger-animation > *:nth-child(2) { animation-delay: 50ms; }
        .stagger-animation > *:nth-child(3) { animation-delay: 100ms; }
        .stagger-animation > *:nth-child(4) { animation-delay: 150ms; }
        .stagger-animation > *:nth-child(5) { animation-delay: 200ms; }
        .stagger-animation > *:nth-child(6) { animation-delay: 250ms; }
        .stagger-animation > *:nth-child(7) { animation-delay: 300ms; }
        .stagger-animation > *:nth-child(8) { animation-delay: 350ms; }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeInUp {
            animation: fadeInUp 0.6s ease-out forwards;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .animate-fadeIn {
            animation: fadeIn 0.6s ease-out forwards;
        }
    </style>
</x-app-layout>
