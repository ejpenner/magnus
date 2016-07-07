@extends('layouts.app')

@section('content')
    <div class="container">
        {!! Form::model($opus, ['method' => 'PATCH', 'action'=>['OpusController@update', $opus->slug], 'files'=>true, 'id'=>'upload-file']) !!}

        <div class="panel panel-default">
            <div class="panel-heading">
                Uploaded File
            </div>
            <div class="panel-body">
                <div class="text-center">
                    <img id="preview-edit" src="/{{ $opus->getImage() }}">
                </div>
            </div>
        </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    Edit Opus
                </div>
                <div class="panel-body">
                    @include('opus._form')
                </div>
            </div>

            {!! Form::close() !!}
        </div>
        <div class="col-md-4 col-md-offset-1">
            {{--<div class="form-group">--}}
            {{--{!! Form::label('title', 'Submission Title') !!}--}}
            {{--{!! Form::text('title', null, ['class'=>'form-control']) !!}--}}
            {{--</div>--}}
            {{--<div class="form-group">--}}
            {{--{!! Form::label('comment', 'Artist\'s Comments') !!}--}}
            {{--{!! Form::textarea('comment', null, ['class'=>'form-control']) !!}--}}
            {{--</div>--}}
            {{--<div class="form-group">--}}
            {{--{!! Form::label('tags', 'Tags') !!}--}}
            {{--{!! Form::text('tags', isset($tagString) ? $tagString : null, ['class'=>'form-control']) !!}--}}
            {{--<p class="alert alert-info">Be sure to separate tags with spaces</p>--}}
            {{--</div>--}}
            {{--<div class="form-group">--}}
            {{--<input type="file" name="image" id="image" class="form-control">--}}
            {{--</div>--}}
            {{--{!! Form::submit('Submit', ['class' => 'form-control']) !!}--}}

        </div>
    {{--<div class="col-md-5 uploader">--}}
    {{--<div class="form-group">--}}
    {{--<label for="">Preview</label>--}}
    {{--<p><img id="preview-edit" src="/{{ $opus->getImage() }}"></p>--}}
    {{--</div>--}}
    {{--</div>--}}
@endsection