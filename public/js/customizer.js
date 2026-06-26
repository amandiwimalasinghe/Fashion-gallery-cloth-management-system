
// Initialize Canvas
const canvas = new fabric.Canvas('c');
let printArea = null;

// DOM Elements
const uploadClothInput = document.getElementById('uploadCloth');
const uploadLogoInput = document.getElementById('uploadLogo');
const addTextBtn = document.getElementById('addTextBtn');
const textInput = document.getElementById('textInput');
const colorPicker = document.getElementById('colorPicker');
const deleteBtn = document.getElementById('deleteBtn');
const saveBtn = document.getElementById('saveBtn');
const controlsSection = document.getElementById('controls-section');
const placeholderMsg = document.getElementById('placeholder-msg');

// Resize Canvas to fit wrapper initially (optional, but good for UI)
// Actually we will resize it to match the uploaded image.

// 1. Upload Base Cloth (Background)
uploadClothInput.addEventListener('change', function (e) {
    const file = e.target.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = function (f) {
        const data = f.target.result;
        fabric.Image.fromURL(data, function (img) {

            // Logic to fit image within a reasonable max size while keeping aspect ratio
            const maxWidth = 600;
            const maxHeight = 600;
            let scale = 1;

            if (img.width > maxWidth || img.height > maxHeight) {
                scale = Math.min(maxWidth / img.width, maxHeight / img.height);
            }

            img.scale(scale);

            // Set canvas dimensions
            canvas.setWidth(img.width * scale);
            canvas.setHeight(img.height * scale);

            // Set background
            canvas.setBackgroundImage(img, canvas.renderAll.bind(canvas), {
                scaleX: scale,
                scaleY: scale
            });

            // UI Updates
            controlsSection.classList.remove('controls-disabled');
            placeholderMsg.style.display = 'none';

            // Add Print Area if not exists
            addPrintArea(canvas.width, canvas.height);

            // Initialize History
            initHistory();
        });
    };
    reader.readAsDataURL(file);
});

// 2. Add Print Area
function addPrintArea(canvasWidth, canvasHeight) {
    if (printArea) {
        canvas.remove(printArea);
    }

    // Default size: 50% of canvas
    const width = canvasWidth * 0.5;
    const height = canvasHeight * 0.5;

    printArea = new fabric.Rect({
        left: (canvasWidth - width) / 2,
        top: (canvasHeight - height) / 2,
        width: width,
        height: height,
        fill: 'rgba(255, 255, 255, 0)', // Transparent
        stroke: '#333',
        strokeDashArray: [5, 5],
        strokeWidth: 2,
        borderColor: 'red',
        cornerColor: 'blue',
        cornerSize: 10,
        transparentCorners: false,
        hasRotatingPoint: false // Usually print areas are rectangular aligned
    });

    // Custom property to identify it
    printArea.id = 'printArea';

    canvas.add(printArea);
    canvas.setActiveObject(printArea);
}

// 3. Add Logo
uploadLogoInput.addEventListener('change', function (e) {
    const file = e.target.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = function (f) {
        fabric.Image.fromURL(f.target.result, function (img) {

            // Resize if too big
            if (img.width > 200) {
                img.scaleToWidth(200);
            }

            // Apply Clipping
            setClipPath(img);

            canvas.add(img);
            canvas.setActiveObject(img);
            img.center();
        });
    };
    reader.readAsDataURL(file);
    uploadLogoInput.value = ''; // Reset
});

// 4. Add Text
addTextBtn.addEventListener('click', function () {
    const text = textInput.value || 'Custom Text';
    const selectedFont = document.getElementById('fontFamily').value;
    const fabricText = new fabric.IText(text, {
        left: 100,
        top: 100,
        fontFamily: selectedFont,
        fill: colorPicker.value,
        fontSize: 40
    });

    setClipPath(fabricText);

    canvas.add(fabricText);
    canvas.setActiveObject(fabricText);
    canvas.centerObject(fabricText);
});

// Helper: Set ClipPath
// Helper: Set ClipPath
function setClipPath(object) {
    if (!printArea) return;

    // Create a clone of the printArea to use as the clipPath
    // Using the actual canvas object as clipPath can cause rendering issues
    printArea.clone(function (cloned) {
        cloned.absolutePositioned = true;
        cloned.left = printArea.left;
        cloned.top = printArea.top;
        cloned.scaleX = printArea.scaleX;
        cloned.scaleY = printArea.scaleY;
        cloned.angle = printArea.angle;

        object.clipPath = cloned;
        canvas.requestRenderAll();
    });
}

// Update clip paths when print area changes
if (canvas) {
    canvas.on('object:modified', function (e) {
        if (e.target === printArea) {
            canvas.getObjects().forEach(obj => {
                if (obj !== printArea && obj !== canvas.backgroundImage) {
                    setClipPath(obj);
                }
            });
        }
    });
}

// 5. Delete Selected
deleteBtn.addEventListener('click', function () {
    const activeObj = canvas.getActiveObject();
    if (activeObj && activeObj !== printArea) { // Don't delete print area easily? Or allow it?
        canvas.remove(activeObj);
    }
});

// 6. Color Picker
colorPicker.addEventListener('input', function () {
    const activeObj = canvas.getActiveObject();
    if (activeObj) {
        if (activeObj.type === 'i-text' || activeObj.type === 'text') {
            activeObj.set('fill', this.value);
            canvas.requestRenderAll();
        }
    }
});

// 8. Save / Export
saveBtn.addEventListener('click', function () {
    if (!canvas.backgroundImage) return alert('Please upload a cloth first.');

    // Hide controls/print area for the screenshot
    if (printArea) {
        printArea.visible = false;
        // Also remove the border/stroke temporarily? The visible=false handles it.
        // BUT, if printArea is hidden, does it still CLIP the objects?
        // In Fabric.js, if clipPath object is not 'visible' or not on canvas, it still clips if assigned.
        // However, we assigned `object.clipPath = printArea`.
        // If `printArea.visible = false`, the clipping shape itself is invisible (good), but does it still function as a mask? Yes.
    }

    canvas.discardActiveObject();
    canvas.requestRenderAll();

    // Export
    // Use multiplier for higher quality
    const dataURL = canvas.toDataURL({
        format: 'png',
        quality: 1,
        multiplier: 2
    });

    // Restore UI
    if (printArea) {
        printArea.visible = true;
    }
    canvas.requestRenderAll();

    // Send to Backend
    fetch('/save-design', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    },
    body: JSON.stringify({ image: dataURL })
    })
        .then(res => res.json())
        .then(data => {
            if (data.url) {
                // Option 1: Download directly
                const link = document.createElement('a');
                link.href = data.url;
                link.download = data.filename;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                alert('Design saved and downloaded!');
            } else {
                alert('Error saving design.');
            }
        })
        .catch(err => console.error(err));
});

// Keyboard Delete Support
document.addEventListener('keydown', function (e) {
    if (e.key === 'Delete' || e.key === 'Backspace') {
        if (e.target.tagName !== 'INPUT') {
            const activeObj = canvas.getActiveObject();
            if (activeObj && activeObj !== printArea) {
                canvas.remove(activeObj);
                saveHistory(); // Save state on delete
            }
        }
    }
    // Undo/Redo Shortcuts
    if ((e.ctrlKey || e.metaKey) && e.key === 'z') {
        e.preventDefault();
        undo();
    }
    if ((e.ctrlKey || e.metaKey) && e.key === 'y') {
        e.preventDefault();
        redo();
    }
});

// --- Advanced Features ---

// 9. Font Selection
const fontFamily = document.getElementById('fontFamily');
fontFamily.addEventListener('change', function () {
    const activeObj = canvas.getActiveObject();
    if (activeObj && (activeObj.type === 'i-text' || activeObj.type === 'text')) {
        activeObj.set("fontFamily", this.value);
        canvas.requestRenderAll();
        saveHistory();
    }
});

// 10. Undo/Redo System
const undoBtn = document.getElementById('undoBtn');
const redoBtn = document.getElementById('redoBtn');

let history = [];
let historyIndex = -1;
let historyProcessing = false;

function saveHistory() {
    if (historyProcessing) return;

    // Remove future history if we are in the middle of the stack
    if (historyIndex < history.length - 1) {
        history = history.slice(0, historyIndex + 1);
    }

    // Save current state
    // IMPORTANT: Include 'id' in the properties to serialize
    history.push(JSON.stringify(canvas.toJSON(['id'])));
    historyIndex++;
}

function undo() {
    if (historyIndex > 0) {
        historyProcessing = true;
        historyIndex--;
        canvas.loadFromJSON(history[historyIndex], function () {
            canvas.renderAll();
            historyProcessing = false;
            // Re-bind objects if needed (like clipPath references might be lost or duplicated)
            // Ideally we re-find the printArea
            const objects = canvas.getObjects();
            const foundPrintArea = objects.find(o => o.id === 'printArea');
            if (foundPrintArea) {
                printArea = foundPrintArea;
            }
            // Re-apply clipping to objects if they lost the reference?
            // In JSON load, fabric usually restores properties.
        });
    }
}

function redo() {
    if (historyIndex < history.length - 1) {
        historyProcessing = true;
        historyIndex++;
        canvas.loadFromJSON(history[historyIndex], function () {
            canvas.renderAll();
            historyProcessing = false;
            const objects = canvas.getObjects();
            const foundPrintArea = objects.find(o => o.id === 'printArea');
            if (foundPrintArea) {
                printArea = foundPrintArea;
            }
        });
    }
}

undoBtn.addEventListener('click', undo);
redoBtn.addEventListener('click', redo);

// Hook into Canvas events to save history
canvas.on('object:added', function (e) {
    if (!historyProcessing) {
        // Initial load of background might trigger this, so be careful.
        // We can check if it's the printArea or user content.
        if (e.target && e.target.id !== 'printArea') {
            // Debounce or just save?
            // saveHistory();
        }
    }
});
canvas.on('object:modified', saveHistory);
canvas.on('object:removed', saveHistory);

// Also save initial state after background load
function initHistory() {
    // Clear and start fresh
    history = [];
    historyIndex = -1;
    saveHistory();
}

// --- Image Filters ---
const brightnessSlider = document.getElementById('brightnessSlider');
const contrastSlider = document.getElementById('contrastSlider');
const resetFiltersBtn = document.getElementById('resetFiltersBtn');
const brightnessValue = document.getElementById('brightnessValue');
const contrastValue = document.getElementById('contrastValue');

function applyFilters() {
    const activeObj = canvas.getActiveObject();
    if (!activeObj || activeObj.type !== 'image') {
        return;
    }

    // Build filters array
    const filters = [];

    // Brightness filter
    const brightness = parseFloat(brightnessSlider.value);
    if (brightness !== 0) {
        filters.push(new fabric.Image.filters.Brightness({ brightness: brightness }));
    }

    // Contrast filter
    const contrast = parseFloat(contrastSlider.value);
    if (contrast !== 0) {
        filters.push(new fabric.Image.filters.Contrast({ contrast: contrast }));
    }

    // Apply filters
    activeObj.filters = filters;
    activeObj.applyFilters();
    canvas.requestRenderAll();
}

// Event Listeners for filters
brightnessSlider.addEventListener('input', function () {
    brightnessValue.textContent = this.value;
    applyFilters();
});

contrastSlider.addEventListener('input', function () {
    contrastValue.textContent = this.value;
    applyFilters();
});

// Reset Filters
resetFiltersBtn.addEventListener('click', function () {
    brightnessSlider.value = 0;
    contrastSlider.value = 0;
    brightnessValue.textContent = '0';
    contrastValue.textContent = '0';
    applyFilters();
});

// When selecting an object, update sliders to reflect its current filters
canvas.on('selection:created', updateFilterSliders);
canvas.on('selection:updated', updateFilterSliders);

function updateFilterSliders() {
    const activeObj = canvas.getActiveObject();
    if (!activeObj || activeObj.type !== 'image') {
        // Reset sliders if not an image
        brightnessSlider.value = 0;
        contrastSlider.value = 0;
        brightnessValue.textContent = '0';
        contrastValue.textContent = '0';
        return;
    }

    // Read current filters from object
    let brightness = 0;
    let contrast = 0;

    if (activeObj.filters) {
        activeObj.filters.forEach(filter => {
            if (filter.type === 'Brightness') {
                brightness = filter.brightness;
            } else if (filter.type === 'Contrast') {
                contrast = filter.contrast;
            }
        });
    }

    brightnessSlider.value = brightness;
    contrastSlider.value = contrast;
    brightnessValue.textContent = brightness.toFixed(2);
    contrastValue.textContent = contrast.toFixed(2);
}

// --- Text Effects ---
const textOpacitySlider = document.getElementById('textOpacitySlider');
const textOpacityValue = document.getElementById('textOpacityValue');
const strokeWidthSlider = document.getElementById('strokeWidthSlider');
const strokeWidthValue = document.getElementById('strokeWidthValue');
const strokeColorPicker = document.getElementById('strokeColorPicker');
const shadowToggle = document.getElementById('shadowToggle');

// Apply text opacity
textOpacitySlider.addEventListener('input', function () {
    const activeObj = canvas.getActiveObject();
    if (activeObj && (activeObj.type === 'i-text' || activeObj.type === 'text')) {
        activeObj.set('opacity', parseFloat(this.value));
        canvas.requestRenderAll();
        textOpacityValue.textContent = Math.round(this.value * 100) + '%';
    }
});

// Apply stroke width
strokeWidthSlider.addEventListener('input', function () {
    const activeObj = canvas.getActiveObject();
    if (activeObj && (activeObj.type === 'i-text' || activeObj.type === 'text')) {
        activeObj.set('strokeWidth', parseFloat(this.value));
        canvas.requestRenderAll();
        strokeWidthValue.textContent = this.value;
    }
});

// Apply stroke color
strokeColorPicker.addEventListener('input', function () {
    const activeObj = canvas.getActiveObject();
    if (activeObj && (activeObj.type === 'i-text' || activeObj.type === 'text')) {
        activeObj.set('stroke', this.value);
        canvas.requestRenderAll();
    }
});

// Toggle shadow
shadowToggle.addEventListener('change', function () {
    const activeObj = canvas.getActiveObject();
    if (activeObj && (activeObj.type === 'i-text' || activeObj.type === 'text')) {
        if (this.checked) {
            activeObj.set('shadow', new fabric.Shadow({
                color: 'rgba(0,0,0,0.5)',
                blur: 10,
                offsetX: 5,
                offsetY: 5
            }));
        } else {
            activeObj.set('shadow', null);
        }
        canvas.requestRenderAll();
    }
});

// Update text effect controls when selecting text
canvas.on('selection:created', updateTextEffectControls);
canvas.on('selection:updated', updateTextEffectControls);

function updateTextEffectControls() {
    const activeObj = canvas.getActiveObject();
    if (!activeObj || (activeObj.type !== 'i-text' && activeObj.type !== 'text')) {
        // Reset controls
        textOpacitySlider.value = 1;
        textOpacityValue.textContent = '100%';
        strokeWidthSlider.value = 0;
        strokeWidthValue.textContent = '0';
        strokeColorPicker.value = '#000000';
        shadowToggle.checked = false;
        return;
    }

    // Read current values
    textOpacitySlider.value = activeObj.opacity || 1;
    textOpacityValue.textContent = Math.round((activeObj.opacity || 1) * 100) + '%';
    strokeWidthSlider.value = activeObj.strokeWidth || 0;
    strokeWidthValue.textContent = activeObj.strokeWidth || 0;
    strokeColorPicker.value = activeObj.stroke || '#000000';
    shadowToggle.checked = !!activeObj.shadow;
}
