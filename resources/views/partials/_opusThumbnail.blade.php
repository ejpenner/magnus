<div class="thumbnail-wrap">
    <a href="{{ action('OpusController@show', [$opus->slug]) }}">
        <img class="opus-image" src="/{{ $opus->thumbnail_path }}" alt="{{ $opus->title }}">
    </a>
    @if(Auth::check() and Magnus::isOwnerOrHasRole($opus, config('roles.gmod-code')))
        <div class="opus-overlay">
            @include('partials._operationsDropdownSlug', ['model'=>$opus, 'controller'=>'OpusController'])
        </div>
    @endif
</div>
