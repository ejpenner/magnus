@if(Auth::check())
<div class="reply-toggle container">
    <button class="btn btn-primary reply-btn pull-left btn-xs">Reply</button>
    <div class="container reply-form">
        <div>
            {!! Form::open(['action'=>['CommentController@storeChild', $comment->opus->slug, $comment->id], 'method'=>'post']) !!}
            {!! Form::textarea('body', null, ['class'=>'form-control reply-textarea', 'rows'=>4]) !!}
            {!! Form::submit('Reply', ['class'=>'btn btn-primary']) !!}
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endif