<div class="col-md-3">
    <div class="gallery-item">
        <div class="vcenter">
            <div class="">
                <a href="{{ action('OpusController@show', [$opus->id]) }}">
                    <img src="/{{ $opus->getThumbnail() }}" alt="{{ $opus->title }}">
                </a>
            </div>
            <div class="item-details">
                <h5><a href="{{ action('OpusController@show', [$opus->id]) }}">{{ $opus->title }}</a><br>
                    <small><a href="{{ action('ProfileController@show', $opus->user->slug) }}">{{ $opus->user->name }}</a></small></h5>
                @if(Auth::check() and (Auth::user()->isOwner($opus) or Auth::user()->atLeastHasRole(config('roles.globalModerator'))))
                    @include('partials._operations', ['model' => $opus, 'controller' => 'OpusController'])
                @endif
            </div>
        </div>
    </div>
</div>