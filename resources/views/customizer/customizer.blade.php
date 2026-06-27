<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-gradient-to-br from-[#d4af37] to-[#e5c76b] rounded-xl flex items-center justify-center shadow-lg shadow-[#d4af37]/20">
                    <i class="fas fa-paint-brush text-white text-lg"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900" style="font-family: 'Playfair Display', serif;">
                        Cloth Customizer
                    </h2>
                    <p class="text-sm text-gray-500">Design and personalize your custom apparel</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <button id="undoBtn" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gray-100 text-gray-700 rounded-full font-medium text-sm hover:bg-gray-200 transition-all duration-300" title="Undo (Ctrl+Z)">
                    <i class="fas fa-undo text-[#d4af37]"></i>
                    <span class="hidden sm:inline">Undo</span>
                </button>
                <button id="redoBtn" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gray-100 text-gray-700 rounded-full font-medium text-sm hover:bg-gray-200 transition-all duration-300" title="Redo (Ctrl+Y)">
                    <i class="fas fa-redo text-[#d4af37]"></i>
                    <span class="hidden sm:inline">Redo</span>
                </button>
                <button id="saveBtn" class="inline-flex items-center gap-2 px-6 py-2.5 bg-gradient-to-r from-[#d4af37] to-[#e5c76b] text-white rounded-full font-bold text-sm uppercase tracking-wider hover:shadow-lg hover:shadow-[#d4af37]/30 transition-all duration-300">
                    <i class="fas fa-download"></i>
                    <span>Save Design</span>
                </button>
            </div>
        </div>
    </x-slot>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Google Fonts for Text Tool --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Bebas+Neue&family=Dancing+Script&family=Lobster&family=Montserrat:wght@400;700&family=Oswald:wght@400;700&family=Pacifico&family=Playfair+Display&family=Poppins:wght@400;600&family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    {{-- Fabric.js --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.3.1/fabric.min.js"></script>

    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #d4af37;
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #b5952f;
        }

        .upload-zone {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 2rem;
            border: 2px dashed #e5e7eb;
            border-radius: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            background: #f9fafb;
        }
        .upload-zone:hover {
            border-color: #d4af37;
            background: rgba(212, 175, 55, 0.05);
        }
        .upload-zone i {
            font-size: 2rem;
            color: #9ca3af;
            transition: color 0.3s ease;
        }
        .upload-zone:hover i {
            color: #d4af37;
        }

        .step-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            background: linear-gradient(135deg, #d4af37 0%, #e5c76b 100%);
            color: white;
            border-radius: 50%;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .section-card {
            background: white;
            border-radius: 1rem;
            border: 1px solid #f3f4f6;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        .section-card:hover {
            border-color: rgba(212, 175, 55, 0.3);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem 1.25rem;
            background: linear-gradient(135deg, #1a1a1a 0%, #333 100%);
            color: white;
        }

        .select-field, .input-field {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid #e5e7eb;
            border-radius: 0.75rem;
            font-size: 0.875rem;
            transition: all 0.3s ease;
            background: white;
        }
        .select-field:focus, .input-field:focus {
            outline: none;
            border-color: #d4af37;
            box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.1);
        }

        .slider-container {
            padding: 0.5rem 0;
        }
        .slider-label {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
        }
        .slider-label span:first-child {
            font-size: 0.875rem;
            font-weight: 600;
            color: #374151;
        }
        .slider-value {
            font-size: 0.75rem;
            font-family: monospace;
            background: #f3f4f6;
            padding: 0.25rem 0.5rem;
            border-radius: 0.375rem;
            color: #6b7280;
        }

        input[type="range"] {
            width: 100%;
            height: 6px;
            background: #e5e7eb;
            border-radius: 5px;
            appearance: none;
            cursor: pointer;
        }
        input[type="range"]::-webkit-slider-thumb {
            appearance: none;
            width: 18px;
            height: 18px;
            background: linear-gradient(135deg, #d4af37 0%, #e5c76b 100%);
            border-radius: 50%;
            cursor: pointer;
            box-shadow: 0 2px 6px rgba(212, 175, 55, 0.4);
        }

        input[type="color"] {
            width: 100%;
            height: 44px;
            border: 2px solid #e5e7eb;
            border-radius: 0.75rem;
            cursor: pointer;
            padding: 4px;
            background: white;
        }
        input[type="color"]::-webkit-color-swatch-wrapper {
            padding: 0;
        }
        input[type="color"]::-webkit-color-swatch {
            border: none;
            border-radius: 0.5rem;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            background: #f9fafb;
            border-radius: 0.75rem;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        .checkbox-group:hover {
            background: #f3f4f6;
        }
        .checkbox-group input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: #d4af37;
            cursor: pointer;
        }
        .checkbox-group label {
            font-size: 0.875rem;
            font-weight: 500;
            color: #374151;
            cursor: pointer;
        }

        .btn-primary-custom {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.75rem 1.25rem;
            background: linear-gradient(135deg, #d4af37 0%, #e5c76b 100%);
            color: white;
            border: none;
            border-radius: 0.75rem;
            font-weight: 600;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .btn-primary-custom:hover {
            box-shadow: 0 4px 15px rgba(212, 175, 55, 0.4);
            transform: translateY(-2px);
        }

        .btn-secondary-custom {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.75rem 1.25rem;
            background: #f3f4f6;
            color: #374151;
            border: 2px solid #e5e7eb;
            border-radius: 0.75rem;
            font-weight: 600;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .btn-secondary-custom:hover {
            background: white;
            border-color: #d4af37;
            color: #d4af37;
        }

        .btn-danger-custom {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            width: 100%;
            padding: 0.875rem 1.25rem;
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            border: none;
            border-radius: 0.75rem;
            font-weight: 600;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .btn-danger-custom:hover {
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.4);
            transform: translateY(-2px);
        }

        .canvas-area {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 1rem;
            min-height: 500px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            border: 1px solid #e5e7eb;
        }

        .placeholder-content {
            text-align: center;
            color: #9ca3af;
        }
        .placeholder-content i {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.3;
        }
        .placeholder-content p {
            font-size: 1.125rem;
            font-weight: 600;
            color: #6b7280;
            margin-bottom: 0.5rem;
        }
        .placeholder-content span {
            font-size: 0.875rem;
            color: #9ca3af;
        }

        .controls-disabled {
            opacity: 0.5;
            pointer-events: none;
        }
        .controls-enabled {
            opacity: 1;
            pointer-events: auto;
        }
    </style>

    <div class="py-8 bg-gradient-to-b from-gray-50 to-white min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- Left Panel - Controls (Scrollable) --}}
                <div class="lg:col-span-1 lg:h-[calc(100vh-200px)] lg:overflow-y-auto lg:pr-2 space-y-4 custom-scrollbar">

                    {{-- Step 1: Upload Base Cloth --}}
                    <div class="section-card">
                        <div class="section-header">
                            <span class="step-badge">1</span>
                            <i class="fas fa-tshirt"></i>
                            <span class="font-bold">Upload Cloth</span>
                        </div>
                        <div class="p-5">
                            <label class="upload-zone">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <p class="text-sm text-gray-600"><strong>Click here</strong> or drag & drop</p>
                                <span class="text-xs text-gray-400">PNG, JPG, WEBP</span>
                                <input id="uploadCloth" type="file" class="hidden" accept="image/*" />
                            </label>
                        </div>
                    </div>

                    {{-- Customization Controls (Hidden until cloth is uploaded) --}}
                    <div id="controls-section" class="controls-disabled space-y-4">

                        {{-- Step 2: Add Logo/Image --}}
                        <div class="section-card">
                            <div class="section-header">
                                <span class="step-badge">2</span>
                                <i class="fas fa-image"></i>
                                <span class="font-bold">Add Logo/Image</span>
                            </div>
                            <div class="p-5">
                                <p class="text-sm text-gray-500 mb-4">Upload your brand logo or design</p>
                                <label class="btn-secondary-custom w-full" style="cursor: pointer;">
                                    <i class="fas fa-upload"></i>
                                    Choose Image File
                                    <input id="uploadLogo" type="file" class="hidden" accept="image/*" />
                                </label>
                            </div>
                        </div>

                        {{-- Step 3: Add Text --}}
                        <div class="section-card">
                            <div class="section-header">
                                <span class="step-badge">3</span>
                                <i class="fas fa-font"></i>
                                <span class="font-bold">Add Text</span>
                            </div>
                            <div class="p-5 space-y-4">
                                <p class="text-sm text-gray-500">Add custom text to your design</p>

                                {{-- Font Selector --}}
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Font Family</label>
                                    <select id="fontFamily" class="select-field">
                                        <optgroup label="System Fonts">
                                            <option value="Arial">Arial</option>
                                            <option value="Times New Roman">Times New Roman</option>
                                            <option value="Courier New">Courier New</option>
                                            <option value="Georgia">Georgia</option>
                                            <option value="Verdana">Verdana</option>
                                            <option value="Impact">Impact</option>
                                        </optgroup>
                                        <optgroup label="Google Fonts">
                                            <option value="Roboto">Roboto</option>
                                            <option value="Montserrat">Montserrat</option>
                                            <option value="Poppins">Poppins</option>
                                            <option value="Oswald">Oswald</option>
                                            <option value="Playfair Display">Playfair Display</option>
                                            <option value="Lobster">Lobster</option>
                                            <option value="Pacifico">Pacifico</option>
                                            <option value="Dancing Script">Dancing Script</option>
                                            <option value="Bebas Neue">Bebas Neue</option>
                                        </optgroup>
                                    </select>
                                </div>

                                {{-- Text Input --}}
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Your Text</label>
                                    <div class="flex gap-2">
                                        <input type="text" id="textInput" placeholder="Type something..." class="input-field flex-1">
                                        <button id="addTextBtn" class="btn-primary-custom">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>

                                {{-- Text Color --}}
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Text Color</label>
                                    <input type="color" id="colorPicker" value="#000000">
                                </div>
                            </div>
                        </div>

                        {{-- Step 4: Text Effects --}}
                        <div class="section-card">
                            <div class="section-header">
                                <span class="step-badge">4</span>
                                <i class="fas fa-magic"></i>
                                <span class="font-bold">Text Effects</span>
                            </div>
                            <div class="p-5 space-y-4">
                                <p class="text-sm text-gray-500">Click on text to apply effects</p>

                                {{-- Opacity --}}
                                <div class="slider-container">
                                    <div class="slider-label">
                                        <span>Opacity</span>
                                        <span id="textOpacityValue" class="slider-value">100%</span>
                                    </div>
                                    <input type="range" id="textOpacitySlider" min="0" max="1" step="0.05" value="1">
                                </div>

                                {{-- Stroke Width --}}
                                <div class="slider-container">
                                    <div class="slider-label">
                                        <span>Outline Width</span>
                                        <span id="strokeWidthValue" class="slider-value">0</span>
                                    </div>
                                    <input type="range" id="strokeWidthSlider" min="0" max="5" step="0.5" value="0">
                                </div>

                                {{-- Stroke Color --}}
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Outline Color</label>
                                    <input type="color" id="strokeColorPicker" value="#ffffff">
                                </div>

                                {{-- Shadow --}}
                                <div class="checkbox-group">
                                    <input type="checkbox" id="shadowToggle">
                                    <label for="shadowToggle">Add Drop Shadow</label>
                                </div>
                            </div>
                        </div>

                        {{-- Step 5: Image Adjustments --}}
                        <div class="section-card">
                            <div class="section-header">
                                <span class="step-badge">5</span>
                                <i class="fas fa-sliders-h"></i>
                                <span class="font-bold">Image Adjustments</span>
                            </div>
                            <div class="p-5 space-y-4">
                                <p class="text-sm text-gray-500">Click on image/logo to adjust</p>

                                {{-- Brightness --}}
                                <div class="slider-container">
                                    <div class="slider-label">
                                        <span>Brightness</span>
                                        <span id="brightnessValue" class="slider-value">0</span>
                                    </div>
                                    <input type="range" id="brightnessSlider" min="-1" max="1" step="0.05" value="0">
                                </div>

                                {{-- Contrast --}}
                                <div class="slider-container">
                                    <div class="slider-label">
                                        <span>Contrast</span>
                                        <span id="contrastValue" class="slider-value">0</span>
                                    </div>
                                    <input type="range" id="contrastSlider" min="-1" max="1" step="0.05" value="0">
                                </div>

                                <button id="resetFiltersBtn" class="btn-secondary-custom w-full">
                                    <i class="fas fa-undo"></i>
                                    Reset Adjustments
                                </button>
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="section-card">
                            <div class="p-5">
                                <button id="deleteBtn" class="btn-danger-custom">
                                    <i class="fas fa-trash-alt"></i>
                                    Delete Selected Object
                                </button>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Right Panel - Canvas Area --}}
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden h-full">
                        <div class="bg-gradient-to-r from-[#1a1a1a] to-[#333] px-6 py-4">
                            <h3 class="text-lg font-bold text-white flex items-center gap-2">
                                <i class="fas fa-palette text-[#d4af37]"></i>
                                Design Canvas
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="canvas-area" style="min-height: 550px;">
                                <canvas id="c"></canvas>
                                <div id="placeholder-msg" class="placeholder-content absolute">
                                    <i class="fas fa-image"></i>
                                    <p>Upload a cloth image to start designing</p>
                                    <span>Your design will appear here</span>
                                </div>
                            </div>

                            {{-- Instructions --}}
                            <div class="mt-6 bg-gradient-to-r from-[#d4af37]/10 to-[#e5c76b]/10 rounded-xl p-4 border border-[#d4af37]/20">
                                <h4 class="font-bold text-gray-800 flex items-center gap-2 mb-3">
                                    <i class="fas fa-lightbulb text-[#d4af37]"></i>
                                    Quick Tips
                                </h4>
                                <ul class="text-sm text-gray-600 space-y-2">
                                    <li class="flex items-start gap-2">
                                        <i class="fas fa-check-circle text-green-500 mt-0.5"></i>
                                        <span>Upload your cloth image first, then add logos or text</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <i class="fas fa-check-circle text-green-500 mt-0.5"></i>
                                        <span>Click and drag objects to reposition them</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <i class="fas fa-check-circle text-green-500 mt-0.5"></i>
                                        <span>Use Ctrl+Z / Ctrl+Y for undo/redo</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Main Script --}}
    <script src="{{ asset('js/customizer.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            @if(isset($product) && $product->image)
            const imageUrl = '{{ asset("storage/" . $product->image) }}';
            const uploadClothInput = document.getElementById('uploadCloth');
            
            fetch(imageUrl)
                .then(res => res.blob())
                .then(blob => {
                    const fileNameStr = imageUrl.split('/').pop() || 'garment.jpg';
                    const file = new File([blob], fileNameStr, { type: blob.type });
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    uploadClothInput.files = dataTransfer.files;
                    
                    uploadClothInput.dispatchEvent(new Event('change'));
                })
                .catch(err => {
                    console.error('Error fetching image:', err);
                });
            @endif
        });
    </script>
</x-app-layout>
