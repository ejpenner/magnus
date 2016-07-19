<span class="favorite-button">
    @if(Auth::check() and !Auth::user()->isOwner($opus) and !\Magnus\Favorite::has(Auth::user(), $opus))
        {!! Form::model($opus, ['method' => 'POST', 'class' => 'form-inline', 'action' => ['FavoriteController@store', $opus->slug]]) !!}
        <button class="btn btn-primary" type="submit">Add to Favorites</button>
        {!! Form::close() !!}
    @elseif(!Auth::check() or Auth::user()->isOwner($opus))
        {{--Nothing--}}
    @else
        {!! Form::model($opus, ['method' => 'DELETE', 'class' => 'form-inline', 'action' => ['FavoriteController@destroy', $opus->slug]]) !!}
        <button class="btn btn-secondary" type="submit">Remove from Favorites</button>
        {!! Form::close() !!}
    @endif
</span>