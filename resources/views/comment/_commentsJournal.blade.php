@include('comment._replyJournal')
<div class="container">
    @foreach($comments as $comment)
        @if($comment->parent_id == null)
            <div class="comment-area">
                <div class="container-fluid comment" id="cid:{{ $comment->id }}">
                    @if(!isset($comment->deleted) or !$comment->deleted)
                        @include('comment._comment', ['comment' => $comment])
                    @else
                        <b>Deleted</b>
                    @endif
                </div>
                <div class="container-fluid">
                    @include('comment._childComments', ['comment' => $comment])
                </div>
            </div>
        @endif
    @endforeach
</div>