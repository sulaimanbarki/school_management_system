@props([
    'name' => 'file',
    'id' => null,
    'label' => null,
    'value' => null,
    'accept' => 'image/png,image/jpeg,image/jpg',
    'required' => false,
    'circle' => false,
    'height' => '135px',
    'hint' => 'PNG, JPG up to 2MB',
])

@php
    $inputId = $id ?? $name;
    $hasExisting = !empty($value);
@endphp

<div class="media-uploader-wrapper mb-2" id="wrapper-{{ $inputId }}">
    @if($label)
        <label for="{{ $inputId }}" class="form-label font-weight-bold d-block text-dark mb-1" style="font-size: 13px;">
            {{ $label }}
            @if($required) <span class="text-danger">*</span> @endif
        </label>
    @endif

    <div class="media-dropzone position-relative d-flex flex-column align-items-center justify-content-center text-center p-2 rounded {{ $circle ? 'rounded-circle' : '' }}"
         id="dropzone-{{ $inputId }}"
         style="min-height: {{ $height }}; border: 2px dashed #b8c2cc; background: #fdfdfe; cursor: pointer; transition: all 0.25s ease-in-out; overflow: hidden;">
        
        <!-- Hidden Native File Input (compatible with FormData & standard submissions) -->
        <input type="file"
               name="{{ $name }}"
               id="{{ $inputId }}"
               accept="{{ $accept }}"
               {{ $required && !$hasExisting ? 'required' : '' }}
               class="position-absolute w-100 h-100 opacity-0"
               style="top:0; left:0; cursor: pointer; z-index: 5; opacity: 0;"
               onchange="window.handleMediaChange('{{ $inputId }}', this)">

        <!-- Empty / Placeholder State -->
        <div class="media-placeholder d-flex flex-column align-items-center justify-content-center {{ $hasExisting ? 'd-none' : '' }}" 
             id="placeholder-{{ $inputId }}"
             style="pointer-events: none;">
            <div class="icon-circle mb-1 d-flex align-items-center justify-content-center"
                 style="width: 40px; height: 40px; border-radius: 50%; background: #e8f0fe; color: #1a73e8;">
                <i class="fas fa-cloud-upload-alt fa-lg"></i>
            </div>
            <div style="font-size: 13px; font-weight: 600; color: #374151;">
                <span style="color: #1a73e8; text-decoration: underline;">Browse file</span> or drag & drop
            </div>
            <small class="text-muted" style="font-size: 11px;">{{ $hint }}</small>
        </div>

        <!-- Preview State -->
        <div class="media-preview position-relative w-100 h-100 d-flex flex-column align-items-center justify-content-center {{ $hasExisting ? '' : 'd-none' }}" 
             id="preview-box-{{ $inputId }}">
            <img src="{{ $hasExisting ? $value : '#' }}"
                 alt="Preview"
                 id="preview-img-{{ $inputId }}"
                 class="img-fluid {{ $circle ? 'rounded-circle' : 'rounded' }}"
                 style="max-height: {{ (int)$height - 25 }}px; max-width: 100%; object-fit: contain; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
            
            <div class="preview-info mt-1 d-flex align-items-center justify-content-center w-100">
                <span class="badge badge-light border text-truncate px-2 py-1" 
                      id="filename-{{ $inputId }}" 
                      style="max-width: 150px; font-size: 11px; font-weight: 500;">
                    {{ $hasExisting ? basename($value) : '' }}
                </span>
                <button type="button" 
                        class="btn btn-xs btn-danger ml-2 shadow-sm rounded-circle d-flex align-items-center justify-content-center" 
                        id="remove-btn-{{ $inputId }}"
                        style="width: 22px; height: 22px; z-index: 10; padding: 0;"
                        onclick="window.clearMediaFile('{{ $inputId }}', event)" 
                        title="Remove Image">
                    <i class="fas fa-times" style="font-size: 10px;"></i>
                </button>
            </div>
        </div>
    </div>
</div>

@once
<style>
.media-dropzone:hover {
    border-color: #1a73e8 !important;
    background: #f8fbff !important;
    box-shadow: 0 4px 12px rgba(26, 115, 232, 0.08);
}
.media-dropzone.dragover {
    border-color: #1a73e8 !important;
    background: #eef4ff !important;
    transform: scale(1.01);
}
</style>
<script>
window.handleMediaChange = function(inputId, input) {
    if (input.files && input.files[0]) {
        var file = input.files[0];
        var reader = new FileReader();
        
        reader.onload = function(e) {
            document.getElementById('preview-img-' + inputId).src = e.target.result;
            document.getElementById('filename-' + inputId).innerText = file.name;
            document.getElementById('preview-box-' + inputId).classList.remove('d-none');
            document.getElementById('placeholder-' + inputId).classList.add('d-none');
        };
        
        reader.readAsDataURL(file);
    }
};

window.setMediaPreview = function(inputId, url, filename) {
    if (!url) {
        window.clearMediaFile(inputId);
        return;
    }
    var previewImg = document.getElementById('preview-img-' + inputId);
    if (previewImg) previewImg.src = url;
    var previewBox = document.getElementById('preview-box-' + inputId);
    if (previewBox) previewBox.classList.remove('d-none');
    var placeholder = document.getElementById('placeholder-' + inputId);
    if (placeholder) placeholder.classList.add('d-none');
    var filenameEl = document.getElementById('filename-' + inputId);
    if (filenameEl) filenameEl.innerText = filename || url.split('/').pop();
};

window.clearMediaFile = function(inputId, event) {
    if (event) {
        event.preventDefault();
        event.stopPropagation();
    }
    var input = document.getElementById(inputId);
    if (input) {
        input.value = '';
        // Trigger change event for any listeners
        var evt = document.createEvent("HTMLEvents");
        evt.initEvent("change", false, true);
        input.dispatchEvent(evt);
    }
    var previewImg = document.getElementById('preview-img-' + inputId);
    if (previewImg) previewImg.src = '#';
    var previewBox = document.getElementById('preview-box-' + inputId);
    if (previewBox) previewBox.classList.add('d-none');
    var placeholder = document.getElementById('placeholder-' + inputId);
    if (placeholder) placeholder.classList.remove('d-none');
    var filename = document.getElementById('filename-' + inputId);
    if (filename) filename.innerText = '';
};

// Global drag and drop visual handlers
document.addEventListener('dragover', function(e) {
    var dropzone = e.target.closest('.media-dropzone');
    if (dropzone) {
        dropzone.classList.add('dragover');
    }
});

document.addEventListener('dragleave', function(e) {
    var dropzone = e.target.closest('.media-dropzone');
    if (dropzone) {
        dropzone.classList.remove('dragover');
    }
});

document.addEventListener('drop', function(e) {
    var dropzone = e.target.closest('.media-dropzone');
    if (dropzone) {
        dropzone.classList.remove('dragover');
    }
});
</script>
@endonce
