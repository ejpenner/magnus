<button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#editGalleryModal{{ $id }}">Edit Gallery</button>
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