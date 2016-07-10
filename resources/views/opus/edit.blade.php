@extends('layouts.app')

@section('content')
    <div class="container">
        {!! Form::model($opus, ['method' => 'PATCH', 'action'=>['OpusController@update', $opus->slug], 'files'=>true, 'id'=>'upload-file']) !!}

        <div class="panel panel-default">
            <div class="panel-heading">
                Uploaded File
            </div>
            <div class="uploader">
                <div class="panel-body">
                    <div class="container-fluid">
                        <div class="text-center">
                            <img id="preview-edit" src="/{{ $opus->getImage() }}">
                        </div>
                    </div>
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
@endsection