<div class="container-fluid">
    <h3><a href="{{ action('ProfileController@show', $user->slug) }}"><img src="{{ $user->getAvatar() }}"></a> {!! $user->decorateName() !!}</h3>
    @if(Auth::check())
        <div class="pull-right">
            @include('profile._watchModal', ['user'=>$user])
        </div>
    @endif
    @if(isset($profile->biography))
        <p>{{ $profile->biography }}</p>
    @endif
</div>