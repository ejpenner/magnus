@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                New Opus
            </div>
            <div class="panel-body">
                {!! Form::open(['action'=>['OpusController@store'], 'files'=>true, 'id'=>'upload-file']) !!}
                <div class="panel panel-default preview-container">
                    <div class="panel-heading">
                        Preview
                    </div>
                    <div class="panel-body">
                        <div class="uploader">
                            <div class="form-group">
                                <div class="container-fluid">
                                    <img id="preview" src="#">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @include('opus._form')
            </div>
        </div>
    </div>
@endsection