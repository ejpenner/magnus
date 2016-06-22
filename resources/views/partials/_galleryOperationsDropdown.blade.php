<div id="editGalleryModal{{ $id }}" class="modal fade" role="form">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Create Gallery</h4>
            </div>
            <div class="modal-body">
                {!! Form::model($gallery, ['method'=>'patch', 'action'=>['GalleryController@update', $gallery->id]]) !!}
                @include('gallery._form')
                {!! Form::close() !!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="btn-group">
    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Actions <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
        <li><button type="button" class="btn btn-link" data-toggle="modal" data-target="#editGalleryModal{{ $id }}">Edit Gallery</button></li>
        {!! Form::model($gallery, ['method'=>'delete', 'class'=>'delete-confirm operations', 'action'=>['GalleryController@destroy', $gallery->id]]) !!}
        <li><button type="submit" class="btn btn-link"><i class="fa fa-trash"></i> Delete</button></li>
        {!! Form::close() !!}
    </ul>
</div>