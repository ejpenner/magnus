<div class="text-center">
    <div class="opus-display">
        <img id="preview" class="opus-show" src="{{ $opus->getPreview() }}" alt="preview">
        <div class="fullview-box" style="min-height: {{ $metadata['previewHeight'] }}px">
            <img id="fullview" class="opus-show" src="/images/assets/loading.gif" alt="full view" data-src="{{ $opus->getImage() }}">
        </div>
    </div>
</div>
