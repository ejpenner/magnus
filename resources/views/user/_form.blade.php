<div class="form-group">
    <div class="form-inline">
        {!! Form::label('name', 'Name') !!}
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    <div class="form-inline">
        {!! Form::label('email', 'E-Mail') !!}
        {!! Form::text('email', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    <div class="form-inline">
        {!! Form::label('timezone', 'Timezone') !!}
        {!! Timezone::selectForm(isset($user->timezone) ? $user->timezone : null, 'Select your timezone',['class'=>'form-control','name'=>'timezone']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
</div>