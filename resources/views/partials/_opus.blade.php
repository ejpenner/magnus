<div class="col-md-3">
    <div class="gallery-item">
        <div class="vcenter">
            <a href="{{ action('OpusController@show', [$opus->id]) }}">
                <img src="/{{ $opus->getThumbnail() }}" alt="{{ $opus->title }}">
            </a>
            <div class="item-details">
                <h5><strong><a href="{{ action('OpusController@show', [$opus->id]) }}">{{ $opus->title }}</a></strong>
                    @if(!isset($showName) or $showName)
                        <br><a href="{{ action('ProfileController@show', $opus->user->slug) }}">{!! $opus->user->decorateUsername() !!}</a>
                    @endif
                </h5>
            </div>
        </div>
        <div class="gallery-operations">
            @if(Auth::check() and Magnus::isOwnerOrHasRole($opus, config('roles.moderator')))
                @include('partials._operations', ['model' => $opus, 'controller' => 'OpusController'])
            @endif
        </div>
    </div>
</div>