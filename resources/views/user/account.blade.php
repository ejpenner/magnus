@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Account Management</h3>
        <hr>
        <ul class="standard">
            <li><a href="{{ action('UserController@editAccount', $user->slug) }}">Edit Account Information</a></li>
            <li><a href="{{ action('UserController@preferences', $user->slug) }}">Edit Site Preferences</a></li>
        </ul>
    </div>
@endsection