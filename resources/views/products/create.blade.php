<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div
                class="w-12 h-12 bg-gradient-to-br from-[#d4af37] to-[#e5c76b] rounded-xl flex items-center justify-center shadow-lg shadow-[#d4af37]/20">
                <i class="fas fa-plus text-white text-lg"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-900" style="font-family: 'Playfair Display', serif;">
                    {{ __('Create New Design') }}
                </h2>
                <p class="text-sm text-gray-500">Upload and share your creativity with the world</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-b from-gray-50 to-white min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

                <!-- Form Header -->
                <div class="bg-gradient-to-r from-gray-50 to-white px-8 py-6 border-b border-gray-100">
                    <h3 class="text-xl font-bold text-gray-900" style="font-family: 'Playfair Display', serif;">
                        <i class="fas fa-palette text-[#d4af37] mr-2"></i>
                        Add a Masterpiece
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">Fill in the details below to showcase your design</p>
                </div>

                <div class="p-8">
                    <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data"
                        class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Design Name -->
                            <div class="md:col-span-2">
                                <label for="name"
                                    class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                    <i class="fas fa-tag text-[#d4af37] mr-1"></i> Design Name *
                                </label>
                                <x-text-input id="name" class="block w-full" type="text" name="name" required
                                    placeholder="e.g. Summer Silk Dress" />
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
                                        name="price" required placeholder="5000.00" />
                                </div>
                            </div>

                            <!-- Stock -->
                            <div>
                                <label for="stock_quantity"
                                    class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                    <i class="fas fa-boxes text-[#d4af37] mr-1"></i> Available Quantity *
                                </label>
                                <x-text-input id="stock_quantity" class="block w-full" type="number"
                                    name="stock_quantity" required placeholder="10" />
                            </div>

                            <!-- Category -->
                            <div>
                                <label for="category"
                                    class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                    <i class="fas fa-folder text-[#d4af37] mr-1"></i> Category *
                                </label>
                                <select id="category" name="category"
                                    class="block w-full border-2 border-gray-200 rounded-xl py-3 px-4 focus:border-[#d4af37] focus:ring-[#d4af37] bg-white cursor-pointer">
                                    <option value="Men">Men</option>
                                    <option value="Women">Women</option>
                                    <option value="Kids">Kids</option>
                                    <option value="Unisex">Unisex</option>
                                    <option value="Accessories">Accessories</option>
                                </select>
                            </div>

                            <!-- Size -->
                            <div>
                                <label for="size"
                                    class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                    <i class="fas fa-ruler text-[#d4af37] mr-1"></i> Size (Optional)
                                </label>
                                <x-text-input id="size" class="block w-full" type="text" name="size"
                                    placeholder="S, M, L, XL" />
                            </div>
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description"
                                class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                <i class="fas fa-align-left text-[#d4af37] mr-1"></i> Description
                            </label>
                            <textarea id="description" name="description" rows="4"
                                class="block w-full border-2 border-gray-200 rounded-xl py-3 px-4 focus:border-[#d4af37] focus:ring-[#d4af37] transition-all"
                                placeholder="Describe the fabric, style, colors, and fit..."></textarea>
                        </div>

                        <!-- Image Upload -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                <i class="fas fa-image text-[#d4af37] mr-1"></i> Product Image *
                            </label>
                            <div class="border-2 border-dashed border-gray-200 rounded-2xl p-8 text-center hover:border-[#d4af37] transition-all duration-300 bg-gray-50 hover:bg-[#d4af37]/5 group cursor-pointer"
                                onclick="document.getElementById('image').click()">
                                <div
                                    class="w-16 h-16 bg-gradient-to-br from-gray-200 to-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:from-[#d4af37]/20 group-hover:to-[#d4af37]/10 transition-all">
                                    <i
                                        class="fas fa-cloud-upload-alt text-2xl text-gray-400 group-hover:text-[#d4af37] transition-colors"></i>
                                </div>
                                <p class="font-semibold text-gray-700 mb-1">Click to upload your design</p>
                                <p class="text-xs text-gray-400">PNG, JPG or JPEG (Max 5MB)</p>
                                <input id="image" name="image" type="file" class="hidden" required accept="image/*"
                                    onchange="updateFileName(this)">
                                <p id="file-name" class="text-sm text-[#d4af37] font-medium mt-3 hidden"></p>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end pt-4 border-t border-gray-100">
                            <button type="submit"
                                class="inline-flex items-center gap-2 bg-gradient-to-r from-[#1a1a1a] to-[#333] text-white px-10 py-4 rounded-xl font-bold uppercase text-sm tracking-widest hover:from-[#d4af37] hover:to-[#b5952f] transition-all duration-300 shadow-lg hover:shadow-[#d4af37]/30 group">
                                <i class="fas fa-upload group-hover:animate-bounce"></i>
                                <span>{{ __('Upload Design') }}</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateFileName(input) {
            const fileNameDisplay = document.getElementById('file-name');
            if (input.files && input.files[0]) {
                fileNameDisplay.textContent = '📎 ' + input.files[0].name;
                fileNameDisplay.classList.remove('hidden');
            }
        }
    </script>
</x-app-layout>