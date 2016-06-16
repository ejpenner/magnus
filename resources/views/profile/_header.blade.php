<h3><a href="{{ action('ProfileController@show', $user->slug) }}"><img src="{{ $user->getAvatar() }}"></a> {{ $user->name }}</h3>
@if(isset($profile->biography))
    <p>{{ $profile->biography }}</p>
@endif
<hr>