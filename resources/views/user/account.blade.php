@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Account Management</h3>
        <hr>
        <ul class="standard">
            <li><a href="{{ action('UserController@editAccount', $user->id) }}">Edit Account Information</a></li>
            <li><a href="{{ action('UserController@changeAccountPassword', $user->id) }}">Change Password</a></li>
            <li><a href="{{ action('UserController@avatar') }}">Change Avatar</a></li>
        </ul>
    </div>
@endsection