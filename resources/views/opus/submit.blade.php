@extends('layouts.app')

@section('content')
    {!! Form::open(['action'=>['OpusController@submit'], 'files'=>true, 'id'=>'upload-file']) !!}
    <div class="col-md-2">
        @if($galleries->count() > 0)
            {!! Form::label('Select Galleries') !!}
            <div class="form-group">
                {{--<select name="gallery_id" class="form-control" id="" multiple>--}}
                    @foreach($galleries as $i => $gallery)
                        {{--<option value="{{ $gallery->id }}">{{ $gallery->name }}</option>--}}
                        {!! Form::label($gallery->name) !!}
                        {!! Form::checkbox('gallery_id'.$i, $gallery->id) !!}
                    @endforeach
                {{--</select>--}}
            </div>
        @endif
    </div>
    <div class="col-md-4">
        @include('opus._form')
        {!! Form::close() !!}
    </div>
    <div class="col-md-4 uploader">
        <div class="form-group">
            <label for="">Preview</label>
            <p><img id="preview" src="#"></p>
        </div>
    </div>
@endsection