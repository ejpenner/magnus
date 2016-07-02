<div class="container">
    @foreach($comment->childComments as $child)
        @if($child->parent_id != null)
            <div class="comment-area">
                <div class="container-fluid comment" id="cid:{{ $comment->id }}">
                    <div class="row">
                        <div class="col-md-2 comment-avatar">
                            <div class="text-center">
                                <a href="{{ action('ProfileController@show', $child->user->slug) }}">
                                    <img src="{{ $child->user->getAvatar() }}" alt="avatar">
                                </a>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="row"><span class="comment-name">{!! $child->user->decorateUsername() !!}</span>
                                >  <a href="{{ Request::url() }}#cid:{{ $comment->id }}">{!! $comment->user->decorateUsername() !!}</a>
                            </div>
                            <div class="comment-body">
                                <div class="comment-date">{{ $child->created_at }}</div>
                                <p class="comment-text">{{ $child->body }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        @include('comment._replyChild', ['comment'=>$child])
                    </div>
                </div>

                <div class="container-fluid">
                    @include('comment._childCommentShow', ['comment' => $child])
                </div>
            </div>
        @endif
    @endforeach
</div>
