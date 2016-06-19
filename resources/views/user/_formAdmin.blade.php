<div class="form-group col-md-4">
    {!! Form::label('name', 'Name') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-md-4">
    {!! Form::label('username', 'Username') !!}
    {!! Form::text('username', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-md-4">
    {!! Form::label('email', 'E-Mail') !!}
    {!! Form::text('email', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-md-4">
    {!! Form::label('role_id', 'Account Role') !!}
    {!! Form::select('role_id', $roles, null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-md-6">
    {!! Timezone::selectForm('US/Central', 'Select your timezone',['class'=>'form-control','name'=>'timezone']) !!}
</div>

<div class="form-group col-md-4">
    {!! Form::label('password', 'Password') !!}
    {!! Form::password('password', ['class' => 'form-control']) !!}
</div>

<div class="form-group col-md-4">
    {!! Form::label('password_confirmation', 'Confirm Password') !!}
    {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
</div>

<div class="form-group col-md-4">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
</div>
