@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Account Management</h3>
        <hr>
        <ul class="standard">
            <li><a href="{{ action('UserController@editAccount', $user->slug) }}">Edit Account Information</a></li>
            <li><a href="{{ action('UserController@preferences', $user->slug) }}">Edit Site Preferences</a></li>
            <li><a href="{{ action('UserController@changeAccountPassword', $user->slug) }}">Change Password</a></li>
            <li><a href="{{ action('UserController@avatar') }}">Change Avatar</a></li>
        </ul>
    </div>
@endsection