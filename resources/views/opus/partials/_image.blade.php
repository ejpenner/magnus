<div class="opus-display">
        <img id="preview" class="opus-show" src="{{ $opus->getPreview() }}" alt="preview">
        <div class="fullview-box" style="height: {{ $metadata['height'] }}px; width: {{ $metadata['width'] }}px">
            <img id="fullview"  src="/images/assets/loading.gif" alt="full view" data-src="{{ $opus->getImage() }}">
        </div>
</div>