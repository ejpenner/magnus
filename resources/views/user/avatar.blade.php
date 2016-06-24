@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-2">
                <p>Current Avatar</p>
                <img src="{{ Auth::user()->getAvatar() }}" alt="">
            </div>
            <div class="col-md-8">
                <form id="avatar-form" action="{{ action('UserController@uploadAvatar') }}">
                    {!! csrf_field() !!}
                    <canvas id="avatar-cropper" width="600" height="400"></canvas>
                    <div class="form-group form-inline">
                        <input type="file" name="avatar-src" id="avatar-file" class="form-control">
                        <button class="crop-submit btn btn-primary">Crop</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection