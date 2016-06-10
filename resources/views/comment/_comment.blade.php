<div class="container reply-area form-group">
    {!! Form::open(['action'=>['CommentController@store', $gallery->id, $piece->id], 'method'=>'post']) !!}
    {!! Form::textarea('comment', null, ['class'=>'form-control', 'rows'=>'4']) !!}
    {!! Form::submit('Reply', ['class'=>'btn btn-primary']) !!}
    {!! Form::close() !!}
</div>
@foreach($comments as $comment)
    @if($comment->parent_id == null)
        <div class="container comment">
            <div class="col-md-2 comment-avatar">
                <div class="text-center">
                    <a href="{{ action('ProfileController@show', $comment->user->slug) }}">
                        <img src="{{ $comment->user->getAvatar() }}" alt="avatar"><br>
                        {{ $comment->user->name }}
                    </a>
                </div>
            </div>
            <div class="col-md-9 comment-body">
                {{ $comment->body }}<br>
                {{ $comment->id }}
            </div>
        </div>
        <div class="container reply-area form-group">
            {!! Form::open(['action'=>['CommentController@storeNested', $gallery->id, $comment->piece->id, $comment->id], 'method'=>'post']) !!}
            {!! Form::textarea('comment', null, ['class'=>'form-control', 'rows'=>4]) !!}
            {!! Form::submit('Reply', ['class'=>'btn btn-primary']) !!}
            {!! Form::close() !!}
        </div>
        <div class="container">
            @include('comment._childComment', ['comment' => $comment, 'piece'=>$piece])
        </div>
    @endif
@endforeach
