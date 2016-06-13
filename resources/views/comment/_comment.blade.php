<div class="reply-toggle container">
    <button class="btn btn-default reply-btn">Reply</button>
    <div class="container reply-form form-group">
        <div>
            {!! Form::open(['action'=>['CommentController@store', $gallery->id, $piece->id], 'method'=>'post']) !!}
            {!! Form::textarea('body', null, ['class'=>'form-control', 'rows'=>'4']) !!}
            {!! Form::submit('Reply', ['class'=>'btn btn-primary']) !!}
            {!! Form::close() !!}
        </div>
    </div>
</div>
<div class="container-fluid">
    @foreach($comments as $comment)
        @if($comment->parent_id == null)
            <div class="comment-area">
                <div class="container-fluid comment" id="{{ $comment->id }}">
                    <div class="row">
                        <div class="col-md-2 comment-avatar">
                            <div class="text-center">
                                <a href="{{ action('ProfileController@show', $comment->user->slug) }}">
                                    <img src="{{ $comment->user->getAvatar() }}" alt="avatar">
                                </a>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="row"><span class="comment-name">{{ $comment->user->name }}</span></div>
                            <div class="comment-body">
                                <p class="comment-date">{{ $comment->created_at }}</p>
                                <p>{{ $comment->body }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="reply-toggle container">
                    <button class="btn btn-default reply-btn">Reply</button>
                    <div class="container reply-form form-group">
                        <div>
                            {!! Form::open(['action'=>['CommentController@storeChild', $gallery->id, $comment->piece->id, $comment->id], 'method'=>'post']) !!}
                            {!! Form::textarea('body', null, ['class'=>'form-control', 'rows'=>4]) !!}
                            {!! Form::submit('Reply', ['class'=>'btn btn-primary']) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    @include('comment._childComment', ['comment' => $comment, 'piece'=>$piece])
                </div>
            </div>
        @endif
    @endforeach
</div>