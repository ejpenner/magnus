@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-2">
                <p>{{ $user->name }}'s current avatar</p>
                <img src="{{ $user->getAvatar() }}" alt="avatar">
            </div>
            <div class="col-md-8">
                <form id="avatar-form" action="{{ action('UserController@uploadAvatarAdmin', $user->id) }}">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <input type="file" name="avatar-src" id="avatar-file" class="form-control">
                    </div>
                    <canvas id="avatar-cropper" width="600" height="400"></canvas>
                    <button class="crop-submit btn btn-primary">Crop</button>
                </form>
            </div>
        </div>
    </div>
@endsection