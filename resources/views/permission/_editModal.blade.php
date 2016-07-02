<button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#editPermissionModal{{ $id }}">Edit Schema</button>
<div id="editPermissionModal{{ $id }}" class="modal fade" role="form">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Modify Schema</h4>
            </div>

            <div class="modal-body">
                {!! Form::model($model, ['method'=>'PATCH', 'action'=>['PermissionController@update', $model->id]]) !!}
                @include('permission._form')
                {!! Form::close() !!}
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>