<div class="form-group">
    {!! Form::label('name', 'Name') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('username', 'Username') !!}
    {!! Form::text('username', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('email', 'E-Mail') !!}
    {!! Form::text('email', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    @if(isset($user->roles))
        @foreach($user->roles as $role)
            {{ $role->name }}
        @endforeach
    @endif
</div>

<div class="form-group">
    {!! Form::label('role_id', 'Account Role') !!}
    {!! Form::select('role_id', $roles, isset($user->roles) ? $user->roles->first()->id : null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('timezone', 'Timezone') !!}
    {!! Timezone::selectForm(isset($user->timezone) ? $user->timezone : null, 'Select your timezone',['class'=>'form-control','name'=>'timezone']) !!}
</div>

<div class="form-group">
    {!! Form::label('password', 'Password') !!}
    {!! Form::password('password', ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('password_confirmation', 'Confirm Password') !!}
    {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
</div>
