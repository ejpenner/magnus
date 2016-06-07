@extends('layouts.app')

@section('content')
    <div class="col-md-4 col-md-offset-1">
        {!! Form::model($piece, ['method' => 'PATCH', 'action'=>['PieceController@update', $gallery->id, $piece->id], 'files'=>true, 'id'=>'upload-file']) !!}
        <div class="form-group">
            {!! Form::label('title', 'Submission Title') !!}
            {!! Form::text('title', null, ['class'=>'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('comment', 'Artist\'s Comments') !!}
            {!! Form::textarea('comment', null, ['class'=>'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('tags', 'Tags') !!}
            {!! Form::text('tags', $piece->stringifyTags(), ['class'=>'form-control']) !!}
            <p class="alert alert-info">Be sure to separate tags with spaces</p>
        </div>
        <div class="form-group">
            <input type="file" name="image" id="image" class="form-control">
        </div>
        {!! Form::submit('Submit', ['class' => 'form-control']) !!}
        {!! Form::close() !!}
    </div>
    <div class="col-md-5 uploader">
        <div class="form-group">
            <label for="">Preview</label>
            <p><img id="preview-edit" src="/{{ $piece->getImage() }}"></p>
        </div>
    </div>
@endsection