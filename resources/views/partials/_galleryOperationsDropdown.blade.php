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