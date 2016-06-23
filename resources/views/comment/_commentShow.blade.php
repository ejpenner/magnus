<div class="container">
    @foreach($comment->childComments as $c)
        @if($c->parent_id != null)
            <div class="comment-area">
                <div class="container-fluid comment" id="{{ $comment->id }}">
                    <div class="row">
                        <div class="col-md-2 comment-avatar">
                            <div class="text-center">
                                <a href="{{ action('ProfileController@show', $c->user->slug) }}">
                                    <img src="{{ $c->user->getAvatar() }}" alt="avatar">
                                </a>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="row"><span class="comment-name">{{ $c->user->name }}</span>
                                >  <a href="{{ Request::url() }}#{{ $comment->id }}">{{ $comment->user->name }}</a>
                            </div>
                            <div class="comment-body">
                                <div class="comment-date">{{ $c->created_at }}</div>
                                <p class="comment-text">{{ $c->body }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        @include('comment._replyChild', ['comment'=>$c])
                    </div>
                </div>

                <div class="container-fluid">
                    @include('comment._childCommentShow', ['comment' => $c])
                </div>
            </div>
        @endif
    @endforeach
</div>
