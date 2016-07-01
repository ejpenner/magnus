<div class="col-md-3">
    <div class="gallery-item">
        <div class="vcenter">
            <a href="{{ action('OpusController@show', [$opus->id]) }}">
                <img src="/{{ $opus->thumbnail_path }}" alt="{{ $opus->title }}">
            </a>
            <div class="item-details">
                <h5><strong><a href="{{ action('OpusController@show', [$opus->id]) }}">{{ $opus->title }}</a></strong>
                    @if(!isset($showName) or $showName)
                        <br><a href="{{ action('ProfileController@show', $opus->uslug) }}">{!! Magnus::usernameID($opus->user_id) !!}</a>
                    @endif
                </h5>
            </div>
        </div>
        <div class="gallery-operations">
            @if(Auth::check() and (Magnus::isOwner(Auth::user(), $opus) or Auth::user()->atLeastHasRole(config('roles.globalModerator'))))
                @include('partials._operations', ['model' => $opus, 'controller' => 'OpusController'])
            @endif
        </div>
    </div>
</div>