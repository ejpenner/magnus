<div class="container">
    <h3>
        <a href="{{ action('ProfileController@show', $user->slug) }}">
            <img class="avatar" src="{{ $user->getAvatar() }}">
        </a>
        {!! $user->decorateName() !!}
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