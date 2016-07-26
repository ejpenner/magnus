<div class="form-group">
    {!! Form::label('role_name', 'Role Name') !!}
    {!! Form::text('role_name', null, ['class'=>'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('level', 'Role Level') !!}
    {!! Form::text('level', null, ['class'=>'form-control']) !!}
</div>

{!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}