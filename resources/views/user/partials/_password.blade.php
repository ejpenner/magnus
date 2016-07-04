@if (Auth::user()->id == $user->id)
    <div class="form-group">
        {!! Form::label('old_password', 'Old Password') !!}
        {!! Form::password('old_password', ['class' => 'form-control']) !!}
    </div>
@endif

<div class="form-group">
    {!! Form::label('password', 'New Password') !!}
    {!! Form::password('password', ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('password_confirmation', 'Confirm New Password') !!}
    {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
</div>
