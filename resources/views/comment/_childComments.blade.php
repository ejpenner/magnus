@foreach($comment->allChildComments as $childComment)
    <div class="child-comment container">
        <div class="container-fluid comment" id="cid:{{ $childComment->id }}">
            @if(!isset($childComment->deleted) or !$childComment->deleted)
                @include('comment._childComment', ['childComment' => $childComment])
            @else
                <b>Deleted</b>
            @endif
        </div>
        @if($childComment->allChildComments->count() >= 2)
            <div>
                <a class="btn btn-link" href="{{ action('CommentController@show', $childComment->id) }}">View More</a>
            </div>
        @elseif($childComment->allChildComments->count() < 2)
            @include('comment._childComments', ['comment' => $childComment])
        @endif
    </div>
@endforeach