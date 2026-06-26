<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-gradient-to-br from-[#d4af37] to-[#e5c76b] rounded-xl flex items-center justify-center shadow-lg shadow-[#d4af37]/20">
                    <i class="fas fa-person-booth text-white text-lg"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900" style="font-family: 'Playfair Display', serif;">
                        Virtual Fitting Room
                    </h2>
                    <p class="text-sm text-gray-500">Try on clothes virtually before you buy</p>
                </div>
            </div>
            <button id="helpBtn" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-full font-medium text-sm hover:bg-gray-200 transition-all duration-300">
                <i class="fas fa-question-circle text-[#d4af37]"></i>
                Help
            </button>
        </div>
    </x-slot>

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
    </style>

    <div class="py-8 bg-gradient-to-b from-gray-50 to-white min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Flash Messages Container -->
            <div id="flashMessages" class="mb-6 space-y-2"></div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Left Panel - Upload & Controls (Scrollable) -->
                <div class="lg:col-span-1 lg:h-[calc(100vh-200px)] lg:overflow-y-auto lg:pr-2 space-y-6 custom-scrollbar">
                    
                    <!-- Upload Section -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-[#1a1a1a] to-[#333] px-6 py-4">
                            <h3 class="text-lg font-bold text-white flex items-center gap-2">
                                <i class="fas fa-cloud-upload-alt text-[#d4af37]"></i>
                                Upload Garment
                            </h3>
                        </div>
                        <div class="p-6">
                            <form id="uploadForm" enctype="multipart/form-data" class="space-y-5">
                                @csrf
                                
                                <!-- File Upload -->
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                        <i class="fas fa-image text-[#d4af37] mr-1"></i> Select Garment Image
                                    </label>
                                    <div class="relative">
                                        <input type="file" name="file" id="file" accept="image/*" required class="hidden">
                                        <label for="file" class="flex items-center justify-center gap-3 w-full h-48 border-2 border-dashed border-gray-200 rounded-xl cursor-pointer hover:border-[#d4af37] hover:bg-[#d4af37]/5 transition-all duration-300 group overflow-hidden relative">
                                            <div id="file-placeholder" class="text-center">
                                                <i class="fas fa-cloud-upload-alt text-3xl text-gray-300 group-hover:text-[#d4af37] transition-colors mb-2"></i>
                                                <p id="file-label" class="text-sm text-gray-500 group-hover:text-gray-700">Click to choose an image</p>
                                                <p id="file-name" class="text-xs text-gray-400 mt-1"></p>
                                            </div>
                                            <img id="file-preview" class="absolute inset-0 w-full h-full object-contain hidden bg-gray-50 z-0" src="">
                                        </label>
                                    </div>
                                </div>

                                <!-- Garment Type -->
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                        <i class="fas fa-tshirt text-[#d4af37] mr-1"></i> Garment Type
                                    </label>
                                    <select name="clothing_type" id="clothing_type" required
                                        class="w-full py-3 px-4 border-2 border-gray-200 rounded-xl focus:border-[#d4af37] focus:ring-[#d4af37] transition-all text-gray-700 font-medium">
                                        <option value="">-- Select type --</option>
                                        <option value="shirt">Shirt / Top</option>
                                        <option value="pants">Pants</option>
                                        <option value="short_pants">Shorts</option>
                                        <option value="frock">Dress (Long)</option>
                                        <option value="short_frock">Dress (Short)</option>
                                    </select>
                                </div>

                                <!-- Action Buttons -->
                                <div class="grid grid-cols-2 gap-3 pt-2">
                                    <button type="submit" id="submitBtn" 
                                        class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-[#d4af37] to-[#e5c76b] text-white py-3 px-4 rounded-xl font-bold text-sm uppercase tracking-wider hover:shadow-lg hover:shadow-[#d4af37]/30 transition-all duration-300">
                                        <i class="fas fa-magic"></i>
                                        Start
                                    </button>
                                    <button type="button" id="endBtn" disabled
                                        class="inline-flex items-center justify-center gap-2 bg-red-500 text-white py-3 px-4 rounded-xl font-bold text-sm uppercase tracking-wider hover:bg-red-600 transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed">
                                        <i class="fas fa-stop"></i>
                                        End
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Adjustment Controls -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-[#1a1a1a] to-[#333] px-6 py-4">
                            <h3 class="text-lg font-bold text-white flex items-center gap-2">
                                <i class="fas fa-sliders-h text-[#d4af37]"></i>
                                Adjustment Controls
                            </h3>
                        </div>
                        <div class="p-6 space-y-5">
                            <!-- Width Scale -->
                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <label class="text-sm font-semibold text-gray-700">Width Scale</label>
                                    <span id="scaleWidthVal" class="text-xs font-mono bg-gray-100 px-2 py-1 rounded">1.0</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="range" id="scaleWidth" min="0.5" max="4.0" step="0.01" value="1.0"
                                        class="flex-1 h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-[#d4af37]">
                                    <input type="number" id="scaleWidthInput" min="0.5" max="4.0" step="0.01" value="1.0"
                                        class="w-16 text-center text-sm border border-gray-200 rounded-lg py-1 focus:border-[#d4af37] focus:ring-[#d4af37]">
                                </div>
                            </div>

                            <!-- Height Scale -->
                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <label class="text-sm font-semibold text-gray-700">Height Scale</label>
                                    <span id="scaleHeightVal" class="text-xs font-mono bg-gray-100 px-2 py-1 rounded">1.0</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="range" id="scaleHeight" min="0.5" max="4.0" step="0.01" value="1.0"
                                        class="flex-1 h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-[#d4af37]">
                                    <input type="number" id="scaleHeightInput" min="0.5" max="4.0" step="0.01" value="1.0"
                                        class="w-16 text-center text-sm border border-gray-200 rounded-lg py-1 focus:border-[#d4af37] focus:ring-[#d4af37]">
                                </div>
                            </div>

                            <!-- Horizontal Position -->
                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <label class="text-sm font-semibold text-gray-700">Horizontal Position</label>
                                    <span id="offsetXVal" class="text-xs font-mono bg-gray-100 px-2 py-1 rounded">0</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="range" id="offsetX" min="-200" max="200" step="1" value="0"
                                        class="flex-1 h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-[#d4af37]">
                                    <input type="number" id="offsetXInput" min="-200" max="200" step="1" value="0"
                                        class="w-16 text-center text-sm border border-gray-200 rounded-lg py-1 focus:border-[#d4af37] focus:ring-[#d4af37]">
                                </div>
                            </div>

                            <!-- Vertical Position -->
                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <label class="text-sm font-semibold text-gray-700">Vertical Position</label>
                                    <span id="offsetYVal" class="text-xs font-mono bg-gray-100 px-2 py-1 rounded">0</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="range" id="offsetY" min="-200" max="200" step="1" value="0"
                                        class="flex-1 h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-[#d4af37]">
                                    <input type="number" id="offsetYInput" min="-200" max="200" step="1" value="0"
                                        class="w-16 text-center text-sm border border-gray-200 rounded-lg py-1 focus:border-[#d4af37] focus:ring-[#d4af37]">
                                </div>
                            </div>

                            <!-- Reset Button -->
                            <button id="resetBtn" 
                                class="w-full inline-flex items-center justify-center gap-2 py-3 px-4 border-2 border-gray-200 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition-all duration-300">
                                <i class="fas fa-undo"></i>
                                Reset to Default
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Right Panel - Video Preview -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden h-full">
                        <div class="bg-gradient-to-r from-[#1a1a1a] to-[#333] px-6 py-4">
                            <h3 class="text-lg font-bold text-white flex items-center gap-2">
                                <i class="fas fa-video text-[#d4af37]"></i>
                                Live Preview
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="relative w-full bg-gray-900 rounded-xl overflow-hidden" style="padding-top: 75%;">
                                <img id="videoFeed" class="absolute inset-0 w-full h-full object-contain hidden">
                                <div id="videoPlaceholder" class="absolute inset-0 flex flex-col items-center justify-center text-center p-8">
                                    <div class="w-24 h-24 bg-gradient-to-br from-gray-700 to-gray-800 rounded-full flex items-center justify-center mb-6">
                                        <i class="fas fa-tshirt text-4xl text-gray-500"></i>
                                    </div>
                                    <h3 class="text-xl font-bold text-white mb-2" style="font-family: 'Playfair Display', serif;">No Active Session</h3>
                                    <p class="text-gray-400 text-sm max-w-xs">Upload a garment image and click "Start" to begin your virtual try-on experience</p>
                                </div>
                            </div>

                            <!-- Instructions -->
                            <div class="mt-6 bg-gradient-to-r from-[#d4af37]/10 to-[#e5c76b]/10 rounded-xl p-4 border border-[#d4af37]/20">
                                <h4 class="font-bold text-gray-800 flex items-center gap-2 mb-3">
                                    <i class="fas fa-lightbulb text-[#d4af37]"></i>
                                    Quick Tips
                                </h4>
                                <ul class="text-sm text-gray-600 space-y-2">
                                    <li class="flex items-start gap-2">
                                        <i class="fas fa-check-circle text-green-500 mt-0.5"></i>
                                        <span>Use a well-lit environment for best results</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <i class="fas fa-check-circle text-green-500 mt-0.5"></i>
                                        <span>Stand facing the camera with arms slightly away from body</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <i class="fas fa-check-circle text-green-500 mt-0.5"></i>
                                        <span>Adjust width/height sliders to fit the garment perfectly</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div id="loadingOverlay" class="fixed inset-0 bg-gray-900/80 backdrop-blur-sm flex flex-col items-center justify-center z-50 hidden">
        <div class="w-16 h-16 border-4 border-[#d4af37]/30 border-t-[#d4af37] rounded-full animate-spin mb-4"></div>
        <h3 class="text-xl font-bold text-white mb-2">Processing your garment...</h3>
        <p class="text-gray-400">This may take a few moments</p>
    </div>

    <script>
        // Session ID for this try-on session
        const sessionId = 'session_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
        
        // Flask backend URL
        const FLASK_BACKEND = '{{ env("FLASK_BACKEND_URL", "http://localhost:5000") }}';

        // DOM Elements
        const videoFeed = document.getElementById('videoFeed');
        const videoPlaceholder = document.getElementById('videoPlaceholder');
        const fileInput = document.getElementById('file');
        const fileLabel = document.getElementById('file-label');
        const fileName = document.getElementById('file-name');
        const filePlaceholder = document.getElementById('file-placeholder');
        const filePreview = document.getElementById('file-preview');
        const uploadForm = document.getElementById('uploadForm');
        const submitBtn = document.getElementById('submitBtn');
        const endBtn = document.getElementById('endBtn');
        const resetBtn = document.getElementById('resetBtn');
        const loadingOverlay = document.getElementById('loadingOverlay');
        const flashMessages = document.getElementById('flashMessages');

        // Control elements
        const controls = {
            scaleWidth: document.getElementById('scaleWidth'),
            scaleWidthInput: document.getElementById('scaleWidthInput'),
            scaleWidthVal: document.getElementById('scaleWidthVal'),
            scaleHeight: document.getElementById('scaleHeight'),
            scaleHeightInput: document.getElementById('scaleHeightInput'),
            scaleHeightVal: document.getElementById('scaleHeightVal'),
            offsetX: document.getElementById('offsetX'),
            offsetXInput: document.getElementById('offsetXInput'),
            offsetXVal: document.getElementById('offsetXVal'),
            offsetY: document.getElementById('offsetY'),
            offsetYInput: document.getElementById('offsetYInput'),
            offsetYVal: document.getElementById('offsetYVal')
        };

        // File input change handler
        function updateFilePreview(file) {
            fileLabel.textContent = file.name;
            fileName.textContent = `Size: ${formatFileSize(file.size)}`;
            
            const reader = new FileReader();
            reader.onload = (e) => {
                filePreview.src = e.target.result;
                filePreview.classList.remove('hidden');
                filePlaceholder.classList.add('hidden'); // Hide the placeholder text/icon
            };
            reader.readAsDataURL(file);
        }

        fileInput.addEventListener('change', (e) => {
            if (e.target.files.length > 0) {
                updateFilePreview(e.target.files[0]);
            } else {
                filePreview.src = '';
                filePreview.classList.add('hidden');
                filePlaceholder.classList.remove('hidden');
                fileLabel.textContent = 'Click to choose an image';
                fileName.textContent = '';
            }
        });

        // Format file size
        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        // Show flash message
        function showFlash(message, type = 'success') {
            const flashEl = document.createElement('div');
            const bgColor = type === 'success' ? 'bg-green-50 border-green-200 text-green-700' : 
                           type === 'error' ? 'bg-red-50 border-red-200 text-red-700' : 
                           'bg-amber-50 border-amber-200 text-amber-700';
            const icon = type === 'success' ? 'fa-check-circle' : 
                        type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle';
            
            flashEl.className = `flex items-center gap-3 p-4 rounded-xl border ${bgColor}`;
            flashEl.innerHTML = `<i class="fas ${icon}"></i> <span class="font-medium">${message}</span>`;
            flashMessages.appendChild(flashEl);

            setTimeout(() => flashEl.remove(), 5000);
        }

        // Show/hide loading overlay
        function showLoading(show) {
            loadingOverlay.classList.toggle('hidden', !show);
        }

        // Debounce function
        function debounce(func, timeout = 200) {
            let timer;
            return (...args) => {
                clearTimeout(timer);
                timer = setTimeout(() => func.apply(this, args), timeout);
            };
        }

        // Update overlay params
        const updateOverlayParams = debounce(async () => {
            try {
                const response = await fetch(`${FLASK_BACKEND}/update_overlay_params`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                    body: JSON.stringify({
                        session_id: sessionId,
                        scale_width: parseFloat(controls.scaleWidth.value),
                        scale_height: parseFloat(controls.scaleHeight.value),
                        offset_x: parseInt(controls.offsetX.value),
                        offset_y: parseInt(controls.offsetY.value)
                    })
                });
                if (!response.ok) showFlash('Failed to update parameters', 'error');
            } catch (error) {
                console.error('Update error:', error);
            }
        });

        // End session
        async function endSession() {
            try {
                const response = await fetch(`${FLASK_BACKEND}/end_session`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ session_id: sessionId })
                });
                if (response.ok) {
                    videoFeed.src = '';
                    videoFeed.classList.add('hidden');
                    videoPlaceholder.classList.remove('hidden');
                    endBtn.disabled = true;
                    showFlash('Session ended', 'success');
                }
            } catch (error) {
                showFlash('Failed to end session', 'error');
            }
        }

        // Form submit handler
        uploadForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            if (!fileInput.files.length) {
                showFlash('Please select an image file', 'error');
                return;
            }

            showLoading(true);

            const formData = new FormData();
            formData.append('file', fileInput.files[0]);
            formData.append('clothing_type', document.getElementById('clothing_type').value);
            formData.append('session_id', sessionId);

            try {
                const response = await fetch(`${FLASK_BACKEND}/upload`, {
                    method: 'POST',
                    body: formData
                });

                showLoading(false);

                if (response.ok) {
                    showFlash('Garment uploaded successfully!', 'success');
                    videoFeed.src = `${FLASK_BACKEND}/video_feed?session_id=${sessionId}`;
                    videoFeed.classList.remove('hidden');
                    videoPlaceholder.classList.add('hidden');
                    endBtn.disabled = false;
                } else {
                    const error = await response.json();
                    showFlash(error.error || 'Upload failed', 'error');
                }
            } catch (error) {
                showLoading(false);
                showFlash('Network error. Please try again.', 'error');
            }
        });

        // Setup control pair (slider + input)
        function setupControlPair(slider, input, display) {
            slider.addEventListener('input', () => {
                input.value = slider.value;
                if (display) display.textContent = slider.value;
                updateOverlayParams();
            });
            input.addEventListener('change', () => {
                const value = Math.min(Math.max(parseFloat(input.value), parseFloat(input.min)), parseFloat(input.max));
                input.value = value;
                slider.value = value;
                if (display) display.textContent = value;
                updateOverlayParams();
            });
        }

        // Reset controls
        function resetControls() {
            controls.scaleWidth.value = controls.scaleWidthInput.value = 1.0;
            controls.scaleWidthVal.textContent = '1.0';
            controls.scaleHeight.value = controls.scaleHeightInput.value = 1.0;
            controls.scaleHeightVal.textContent = '1.0';
            controls.offsetX.value = controls.offsetXInput.value = 0;
            controls.offsetXVal.textContent = '0';
            controls.offsetY.value = controls.offsetYInput.value = 0;
            controls.offsetYVal.textContent = '0';
            updateOverlayParams();
        }

        // Initialize controls
        function initControls() {
            setupControlPair(controls.scaleWidth, controls.scaleWidthInput, controls.scaleWidthVal);
            setupControlPair(controls.scaleHeight, controls.scaleHeightInput, controls.scaleHeightVal);
            setupControlPair(controls.offsetX, controls.offsetXInput, controls.offsetXVal);
            setupControlPair(controls.offsetY, controls.offsetYInput, controls.offsetYVal);
            resetBtn.addEventListener('click', resetControls);
            endBtn.addEventListener('click', endSession);
        }

        // Help button
        document.getElementById('helpBtn').addEventListener('click', () => {
            alert("Virtual Try-On Instructions:\n\n1. Upload garment image\n2. Select clothing type\n3. Click 'Start' to begin\n4. Adjust fit using controls\n5. Click 'End' when finished");
        });

        // Initialize on DOM ready
        document.addEventListener('DOMContentLoaded', () => {
            initControls();
            
            @if(isset($product) && $product->image)
            const imageUrl = '{{ asset("storage/" . $product->image) }}';
            
            fetch(imageUrl)
                .then(res => res.blob())
                .then(blob => {
                    const fileNameStr = imageUrl.split('/').pop() || 'garment.jpg';
                    const file = new File([blob], fileNameStr, { type: blob.type });
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    fileInput.files = dataTransfer.files;
                    
                    updateFilePreview(file);
                    
                    showFlash('Image loaded automatically. Please select the Garment Type and click Start.', 'info');
                })
                .catch(err => {
                    console.error('Error fetching image:', err);
                    showFlash('Failed to auto-load garment image.', 'error');
                });
            @endif
        });
    </script>
</x-app-layout>
