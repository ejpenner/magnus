<div class="container-fluid">
    <ul class="nav nav-pills">
        <li role="presentation"
            @if(Request::is('profile/'.$user->slug.''))
                class="active"
            @endif
        ><a href="{{ action('ProfileController@show', $user->slug) }}">Profile</a></li>
        <li role="presentation"
            @if(Request::is('profile/'.$user->slug.'/opera*'))
                class="active"
            @endif
        ><a href="{{ action('ProfileController@opera', $user->slug) }}">Opera</a></li>
        <li role="presentation"
            @if(Request::is('profile/'.$user->slug.'/galleries*'))
                class="active"
            @endif
        ><a href="{{ action('ProfileController@galleries', $user->slug) }}">Galleries</a></li>
        <li role="presentation"
            @if(Request::is('profile/'.$user->slug.'/journal*'))
                class="active"
            @endif
        ><a href="#">Journal</a></li>
        <li role="presentation"
            @if(Request::is('profile/'.$user->slug.'/favorites*'))
                class="active"
            @endif
        ><a href="#">Favorites</a></li>
    </ul>
    <div class="panel panel-default">
        <div class="panel-body">
            <h3>
                <a class="avatar-link" href="{{ action('ProfileController@show', $user->slug) }}">
                    <img class="avatar" src="{{ $user->getAvatar() }}">
                </a>
                {!! Magnus::username($user->id) !!}
            </h3>
            @if(Auth::check())
                <div class="pull-right">
                    @include('profile._watchModal', ['user'=>$user])
                </div>
            @endif
            @if(isset($details) and $details)
                <p><small>Member since {{ $user->created_at->format('F j, Y') }}</small></p>
                <p>{{ $profile->biography }}</p>
            @endif
        </div>
    </div>
</div>