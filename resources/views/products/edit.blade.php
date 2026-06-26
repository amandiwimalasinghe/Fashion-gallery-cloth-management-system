<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div
                class="w-12 h-12 bg-gradient-to-br from-[#d4af37] to-[#e5c76b] rounded-xl flex items-center justify-center shadow-lg shadow-[#d4af37]/20">
                <i class="fas fa-edit text-white text-lg"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-900" style="font-family: 'Playfair Display', serif;">
                    {{ __('Edit Design') }}
                </h2>
                <p class="text-sm text-gray-500">Update your product details</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-b from-gray-50 to-white min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

                <!-- Form Header with Current Image -->
                <div
                    class="bg-gradient-to-r from-gray-50 to-white px-8 py-6 border-b border-gray-100 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <img src="{{ asset('storage/' . $product->image) }}"
                            class="w-16 h-16 object-cover rounded-xl shadow-md border-2 border-[#d4af37]/20">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900" style="font-family: 'Playfair Display', serif;">
                                {{ $product->name }}
                            </h3>
                            <p class="text-sm text-gray-500">Product ID: #{{ $product->id }}</p>
                        </div>
                    </div>
                    <a href="{{ route('designer.show', Auth::id()) }}"
                        class="inline-flex items-center gap-2 text-gray-500 hover:text-[#d4af37] transition-colors text-sm font-medium">
                        <i class="fas fa-times"></i>
                        Cancel
                    </a>
                </div>

                <div class="p-8">
                    <form method="POST" action="{{ route('products.update', $product->id) }}"
                        enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Design Name -->
                            <div class="md:col-span-2">
                                <label for="name"
                                    class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                    <i class="fas fa-tag text-[#d4af37] mr-1"></i> Design Name *
                                </label>
                                <x-text-input id="name" class="block w-full" type="text" name="name"
                                    :value="$product->name" required />
                            </div>

                            <!-- Price -->
                            <div>
                                <label for="price"
                                    class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                    <i class="fas fa-money-bill text-[#d4af37] mr-1"></i> Price (LKR) *
                                </label>
                                <div class="relative">
                                    <span
                                        class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm font-medium">Rs.</span>
                                    <x-text-input id="price" class="block w-full pl-12" type="number" step="0.01"
                                        name="price" :value="$product->price" required />
                                </div>
                            </div>

                            <!-- Stock -->
                            <div>
                                <label for="stock_quantity"
                                    class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                    <i class="fas fa-boxes text-[#d4af37] mr-1"></i> Available Quantity *
                                </label>
                                <x-text-input id="stock_quantity" class="block w-full" type="number"
                                    name="stock_quantity" :value="$product->stock_quantity" required />
                            </div>

                            <!-- Category -->
                            <div>
                                <label for="category"
                                    class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                    <i class="fas fa-folder text-[#d4af37] mr-1"></i> Category *
                                </label>
                                <select id="category" name="category"
                                    class="block w-full border-2 border-gray-200 rounded-xl py-3 px-4 focus:border-[#d4af37] focus:ring-[#d4af37] bg-white cursor-pointer">
                                    <option value="Men" {{ $product->category == 'Men' ? 'selected' : '' }}>Men</option>
                                    <option value="Women" {{ $product->category == 'Women' ? 'selected' : '' }}>Women
                                    </option>
                                    <option value="Kids" {{ $product->category == 'Kids' ? 'selected' : '' }}>Kids
                                    </option>
                                    <option value="Unisex" {{ $product->category == 'Unisex' ? 'selected' : '' }}>Unisex
                                    </option>
                                    <option value="Accessories" {{ $product->category == 'Accessories' ? 'selected' : '' }}>Accessories</option>
                                </select>
                            </div>

                            <!-- Size -->
                            <div>
                                <label for="size"
                                    class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                    <i class="fas fa-ruler text-[#d4af37] mr-1"></i> Size (Optional)
                                </label>
                                <x-text-input id="size" class="block w-full" type="text" name="size"
                                    :value="$product->size" placeholder="S, M, L, XL" />
                            </div>
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description"
                                class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                <i class="fas fa-align-left text-[#d4af37] mr-1"></i> Description
                            </label>
                            <textarea id="description" name="description" rows="4"
                                class="block w-full border-2 border-gray-200 rounded-xl py-3 px-4 focus:border-[#d4af37] focus:ring-[#d4af37] transition-all">{{ $product->description }}</textarea>
                        </div>

                        <!-- Image Upload -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                <i class="fas fa-image text-[#d4af37] mr-1"></i> Product Image
                            </label>
                            <div class="bg-gray-50 rounded-2xl p-6 border border-gray-200">
                                <div class="flex items-center gap-6">
                                    <div class="shrink-0">
                                        <img src="{{ asset('storage/' . $product->image) }}"
                                            class="w-24 h-24 object-cover rounded-xl shadow-md border-2 border-white">
                                        <p class="text-[10px] text-gray-400 mt-2 text-center">Current</p>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm text-gray-600 mb-2">Upload a new image to replace the current
                                            one (optional)</p>
                                        <input id="image" name="image" type="file"
                                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[#1a1a1a] file:text-white hover:file:bg-[#d4af37] transition cursor-pointer"
                                            accept="image/*">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                            <a href="{{ route('designer.show', Auth::id()) }}"
                                class="inline-flex items-center gap-2 px-6 py-3 border-2 border-gray-200 text-gray-600 rounded-xl font-semibold hover:bg-gray-50 transition-colors">
                                <i class="fas fa-arrow-left"></i>
                                Cancel
                            </a>
                            <button type="submit"
                                class="inline-flex items-center gap-2 bg-gradient-to-r from-[#1a1a1a] to-[#333] text-white px-10 py-3 rounded-xl font-bold uppercase text-sm tracking-widest hover:from-[#d4af37] hover:to-[#b5952f] transition-all duration-300 shadow-lg hover:shadow-[#d4af37]/30">
                                <i class="fas fa-save"></i>
                                <span>{{ __('Update Design') }}</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>