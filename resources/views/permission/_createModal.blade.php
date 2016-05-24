<button type="button" class="btn btn-success" data-toggle="modal" data-target="#createPermissionModal">Add Gallery</button>
<div id="createPermissionModal" class="modal fade" role="form">
    <div class="modal-dialog">

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Create Schema</h4>
            </div>

            <div class="modal-body">
                {!! Form::open(['action'=>['PermissionController@store']]) !!}
                    @include('permission._form')
                {!! Form::close() !!}
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>