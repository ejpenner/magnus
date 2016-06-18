@if(Auth::check())
<div class="reply-toggle container">
    <button class="btn btn-primary reply-btn">Reply</button>
    <div class="container reply-form form-group">
        <div>
            {!! Form::open(['action'=>['CommentController@store', $opus->id], 'method'=>'post']) !!}
            {!! Form::textarea('body', null, ['class'=>'form-control', 'rows'=>'4']) !!}
            {!! Form::submit('Reply', ['class'=>'btn btn-primary']) !!}
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endif