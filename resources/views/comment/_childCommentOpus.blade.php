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
                        <div class="comment-date">{{ $childComment->created_at }}</div>
                        <p class="comment-text">{{ $childComment->body }}</p>
                    </div>
                </div>
            </div>
            <div class="container">
                @include('comment._replyChild', ['comment'=>$childComment])
            </div>
        </div>
        @if($childComment->allChildComments->count() > 1)
            <div>
                <a class="btn btn-link" href="{{ action('CommentController@show', $childComment->id) }}">View More</a>
            </div>
        @elseif($childComment->allChildComments->count() < 2)
            @include('comment._childCommentOpus', ['comment' => $childComment, 'opus'=>$opus])
        @endif
    </div>
@endforeach