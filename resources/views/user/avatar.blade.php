@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-md-8 col-md-offset-2">
            <form id="avatar-form" action="{{ action('UserController@uploadAvatar') }}">
                {!! csrf_field() !!}
                <div class="form-group">
                    <input type="file" name="avatar-src" id="avatar-file" class="form-control">
                </div>
                <canvas id="avatar-cropper" width="600" height="400"></canvas>
                <button class="crop-submit btn btn-primary">Crop</button>
            </form>
        </div>
    </div>
@endsection