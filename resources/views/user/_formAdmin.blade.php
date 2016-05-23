<div class="control-group col-md-6">
    {!! Form::label('name', 'Name') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<div class="control-group col-md-6">
    {!! Form::label('email', 'E-Mail') !!}
    {!! Form::text('email', null, ['class' => 'form-control']) !!}
</div>

<div class="control-group col-md-6">
    {!! Form::label('account_type', 'Account Type') !!}
    {!! Form::select('account_type', array('read-only'=>'read-only','user'=>'user', 'admin'=>'admin'), null, ['class' => 'form-control']) !!}
</div>

<div class="control-group col-md-6">
    {!! Form::label('password', 'Password') !!}
    {!! Form::password('password', ['class' => 'form-control']) !!}
</div>

<div class="control-group col-md-6">
    {!! Form::label('password_confirmation', 'Confirm Password') !!}
    {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
</div>

<div class="control-group col-md-6">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
</div>
