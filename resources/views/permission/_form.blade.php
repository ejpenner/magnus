<div class="form-group">
    {!! Form::label('Schema Name') !!}
    {!! Form::text('schema_name', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    <label>User Role</label><br>
    <div class="radio-inline"><label>{!! Form::radio('role', 'admin') !!} Admin</label></div>
    <div class="radio-inline"><label>{!! Form::radio('role', 'user') !!} User</label></div>
    <div class="radio-inline"><label>{!! Form::radio('role', 'read_only') !!} Read Only</label></div>
</div>

<div class="form-group">
    <label>User Permissions</label><br>
    <div class="checkbox-inline"><label>{!! Form::checkbox('read', 1) !!} Read</label></div>
    <div class="checkbox-inline"><label>{!! Form::checkbox('create', 1) !!} Create</label></div>
    <div class="checkbox-inline"><label>{!! Form::checkbox('edit', 1) !!} Edit</label></div>
    <div class="checkbox-inline"><label>{!! Form::checkbox('destroy', 1) !!} Destroy</label></div>
</div>

<div class="form-group">
    <label>Global Permissions</label><br>
    <div class="checkbox-inline"><label>{!! Form::checkbox('read_all', 1) !!} Read-All</label></div>
    <div class="checkbox-inline"><label>{!! Form::checkbox('create_all', 1) !!} Create-All</label></div>
    <div class="checkbox-inline"><label>{!! Form::checkbox('edit_all', 1) !!} Edit-All</label></div>
    <div class="checkbox-inline"><label>{!! Form::checkbox('destroy_all', 1) !!} Destroy-All</label></div>
</div>

{!! Form::submit('Submit', ['class' => 'form-control']) !!}
