@foreach($comment->allChildComments as $childComment)
    <div class="child-comment">
        <div class="container-fluid comment" id="{{ $comment->id }}">
            <div class="col-md-2 comment-avatar">
                <div class="text-center">
                    <a href="{{ action('ProfileController@show', $childComment->user->slug) }}">
                        <img src="{{ $childComment->user->getAvatar() }}" alt="avatar"><br>
                        <span class="comment-name">{{ $childComment->user->name }}</span>
                    </a>
                </div>
            </div>
            <div class="col-md-9 comment-body">
                <div class="row">{{ $comment->created_at }}</div>
                <div class="row">{{ $childComment->body }}</div>
            </div>
        </div>
        <div class="container reply-area form-group">
            {!! Form::open(['action'=>['CommentController@storeChild', $gallery->id, $comment->piece->id, $comment->id], 'method'=>'post']) !!}
            {!! Form::textarea('body', null, ['class'=>'form-control', 'rows'=>4]) !!}
            {!! Form::submit('Reply', ['class'=>'btn btn-primary']) !!}
            {!! Form::close() !!}
        </div>
        @if($childComment->allChildComments->count() > 0)
            @include('comment._childComment', ['comment' => $childComment])
        @endif
    </div>

@endforeach