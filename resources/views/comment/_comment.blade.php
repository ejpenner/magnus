@include('comment._reply', ['opus'=>$opus])
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
                    @include('comment._replyChild', ['comment'=>$comment])
                </div>

                <div class="container-fluid">
                    @include('comment._childComment', ['comment' => $comment, 'opus'=>$opus])
                </div>
            </div>
        @endif
    @endforeach
</div>