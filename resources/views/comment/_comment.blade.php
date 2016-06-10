@foreach($comments as $comment)
    @if($comment->parent_id == null)
        <div class="container comment">
            <div class="col-md-2 comment-avatar">
                <div class="text-center">
                    <img src="{{ $comment->user->getAvatar() }}" alt="avatar"><br>
                    {{ $comment->user->name }}
                </div>
            </div>
            <div class="col-md-9 comment-body">
                {{ $comment->body }}<br>
                {{ $comment->id }}
            </div>
        </div>
        <div class="container">
            @include('comment._childComment', ['comment' => $comment])
        </div>
    @endif
@endforeach
