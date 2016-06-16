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
    <div class="checkbox-inline"><label>{!! Form::checkbox('private_message_all', 1) !!} View All Private Messages</label></div>
</div>

<div class="form-group">
    <label>Model Permissions</label><br>
    <div class="checkbox-inline"><label>{!! Form::checkbox('piece_all', 1) !!} Piece Admin</label></div>
    <div class="checkbox-inline"><label>{!! Form::checkbox('gallery_all', 1) !!} Gallery Admin</label></div>
    <div class="checkbox-inline"><label>{!! Form::checkbox('comment_all', 1) !!} Comment Admin</label></div>
</div>

<div class="form-group">
    <label>Site Services</label><br>
    <div class="checkbox-inline"><label>{!! Form::checkbox('private_message_access', 1) !!} Private Message Privilege</label></div>
    <div class="checkbox-inline"><label>{!! Form::checkbox('banned', 1) !!} Banned</label></div>
</div>

{!! Form::submit('Save', ['class' => 'form-control']) !!}