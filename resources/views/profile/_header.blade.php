<div class="container-fluid">
    <ul class="nav nav-pills">
        <li role="presentation"
            @if(Request::is('profile/'.$user->slug))
                class="active"
            @endif >
            <a href="{{ action('ProfileController@show', $user->slug) }}">Profile</a>
        </li>
        <li role="presentation"
            @if(Request::is('profile/**/opera*'))
                class="active"
            @endif >
            <a href="{{ action('ProfileController@opera', $user->slug) }}">Art</a>
        </li>
        <li role="presentation"
            @if(Request::is('profile/**/journal*'))
                class="active"
            @endif >
            <a href="{{ action('JournalController@index', $user->slug) }}">Journal</a>
        </li>
        <li role="presentation"
            @if(Request::is('profile/**/favorites*'))
                class="active"
            @endif >
            <a href="{{ action('ProfileController@favorites', $user->slug) }}">Favorites</a>
        </li>
    </ul>
    <div class="panel panel-default">
        <div class="panel-body">
            <h3>
                <a class="avatar-link" href="{{ action('ProfileController@show', $user->slug) }}">
                    <img class="avatar" src="{{ $user->getAvatar() }}">
                </a>
                {!! $user->decorateUsername() !!}
            </h3>
            <span class="pull-right">
                @if(Auth::check() and Magnus::isOwnerOrHasRole($user->profile, config('roles.gmod-code')))
                    <a class="btn btn-primary" href="">Edit Profile</a>
                @endif

                @if(Auth::check())
                    @include('profile._watchModal', ['user'=>$user])
                @endif
                    </span>
            @if(isset($details) and $details)
                <p><small>Member since {{ $user->created_at->format('F j, Y') }}</small></p>
                <p>{{ $user->profile->biography }}</p>
            @endif
        </div>
    </div>
</div>