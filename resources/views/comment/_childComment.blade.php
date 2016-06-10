@foreach($comment->allChildComments as $childComment)
    <div class="child-comment">
                <div class="container comment">
                    <div class="col-md-2 comment-avatar">
                        <div class="text-center">
                            <img src="{{ $childComment->user->getAvatar() }}" alt="avatar"><br>
                            {{ $childComment->user->name }}
                        </div>
                    </div>
                    <div class="col-md-9 comment-body">
                        {{ $childComment->body }}<br>
                        My ID {{ $childComment->id }} <br>
                        Parent ID {{ $childComment->parent_id }}
                    </div>
                </div>
        @if($childComment->allChildComments->count() > 0)
            @include('comment._childComment', ['comment' => $childComment])
        @endif
    </div>
@endforeach