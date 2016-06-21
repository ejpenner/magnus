@if(Auth::check())
    <div class="reply-toggle container">
        <button class="btn btn-primary reply-btn pull-left btn-xs">Reply</button>
        <div class="container reply-form form-group">
            <div>
                {!! Form::open(['action'=>['CommentController@storeChildRemoveNotification', $comment->opus->id, $comment->id, $comment->notification_id], 'method'=>'post']) !!}
                {!! Form::textarea('body', null, ['class'=>'form-control reply-textarea', 'rows'=>4]) !!}
                {!! Form::submit('Reply', ['class'=>'btn btn-primary']) !!}
                {!! Form::checkbox('remove_notify', 1,  1, ['id' => 'remove_notify']) !!}
                {!! Form::label('Remove notification after reply') !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endif