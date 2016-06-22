<div class="col-md-3 vcenter gallery-item">
    <div class="">
        <a href="{{ action('OpusController@show', [$opus->id]) }}">
            <img src="/{{ $opus->getThumbnail() }}" alt="{{ $opus->title }}">
        </a>
    </div>
    <h4><a href="{{ action('OpusController@show', [$opus->id]) }}">{{ $opus->title }}</a> -
        <small><a href="{{ action('ProfileController@show', $opus->user->slug) }}">{{ $opus->user->name }}</a></small></h4>
    @if(Auth::check() and (Auth::user()->isOwner($opus) or Auth::user()->atLeastHasRole(config('roles.globalModerator'))))
        @include('partials._operations', ['model' => $opus, 'controller' => 'OpusController'])
    @endif
</div>