@foreach($comment->allChildComments as $childComment)
    <div class="child-comment">
        <div class="container-fluid comment">
            <div class="col-md-2 comment-avatar">
                <div class="text-center">
                    <a href="{{ action('ProfileController@show', $childComment->user->slug) }}">
                        <img src="{{ $childComment->user->getAvatar() }}" alt="avatar"><br>
                        <span class="comment-name">{{ $childComment->user->name }}</span>
                    </a>
                </div>
            </div>
            <div class="col-md-9 comment-body">
                {{ $childComment->body }}<br>
                My ID {{ $childComment->id }} <br>
                Parent ID {{ $childComment->parent_id }}
            </div>
        </div>
        <div class="container reply-area form-group">
            {!! Form::open(['action'=>['CommentController@storeNested', $gallery->id, $comment->piece->id, $comment->id], 'method'=>'post']) !!}
            {!! Form::textarea('body', null, ['class'=>'form-control', 'rows'=>4]) !!}
            {!! Form::submit('Reply', ['class'=>'btn btn-primary']) !!}
            {!! Form::close() !!}
        </div>
        @if($childComment->allChildComments->count() > 0)
            @include('comment._childComment', ['comment' => $childComment])
        @endif
    </div>

@endforeach