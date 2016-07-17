@if(Auth::check())
<div class="reply-toggle container" id="replyTop">
    <button class="btn btn-primary reply-btn">Reply</button>
    <div class="container reply-form">
        <div>
            {!! Form::open(['action'=>['CommentController@store', $opus->slug], 'method'=>'post']) !!}
            {!! Form::textarea('body', null, ['class'=>'form-control reply-textarea', 'rows'=>'4']) !!}
            @include('partials._formError', ['name' => 'body'])
            {!! Form::submit('Reply', ['class'=>'btn btn-primary']) !!}
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endif