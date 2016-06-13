@foreach($comment->allChildComments as $childComment)
    <div class="child-comment container">
        <div class="container-fluid comment" id="{{ $childComment->id }}">
            <div class="row">
                <div class="col-md-2 comment-avatar">
                    <div class="text-center">
                        <a href="{{ action('ProfileController@show', $childComment->user->slug) }}">
                            <img src="{{ $childComment->user->getAvatar() }}" alt="avatar">
                        </a>
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="row"><span class="comment-name">{{ $childComment->user->name }}</span> > <a href="{{ Request::url() }}#{{ $comment->id }}">{{ $comment->user->name }}</a></div>
                    <div class="comment-body">
                        <p class="comment-date">{{ $childComment->created_at }}</p>
                        <p>{{ $childComment->body }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="reply-toggle container">
            <button class="btn btn-default reply-btn">Reply</button>
            <div class="container reply-form form-group">
                <div>
                    {!! Form::open(['action'=>['CommentController@storeChild', $gallery->id, $comment->piece->id, $childComment->id], 'method'=>'post']) !!}
                    {!! Form::textarea('body', null, ['class'=>'form-control', 'rows'=>4]) !!}
                    {!! Form::submit('Reply', ['class'=>'btn btn-primary']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        @if($childComment->allChildComments->count() > 0)
            @include('comment._childComment', ['comment' => $childComment])
        @endif
    </div>
@endforeach