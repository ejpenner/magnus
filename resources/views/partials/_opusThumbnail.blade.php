<div class="thumbnail-wrap">
    <a href="{{ action($action, $params) }}">
        <div class="opus-image">
            <img src="/{{ $opus->thumbnail_path }}" alt="{{ $opus->title }}">
        </div>
    </a>
    @if(Auth::check() and Magnus::isOwnerOrHasRole($opus, config('roles.gmod-code')))
        <div class="opus-overlay">
            @include('partials._operationsDropdownSlug', ['model'=>$opus, 'controller'=>'OpusController'])
        </div>
    @endif
</div>
