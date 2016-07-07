@extends('layouts.app')
@include('partials._cropperScript')
@section('content')
    <div class="container-fluid">
        <h3>Account Management</h3>
        <hr>
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Change Avatar
                    </div>
                    <div class="panel-body">
                        @include('user.partials._avatar')
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Change User Settings
                    </div>
                    <div class="panel-body">
                        {!! Form::model($user, ['method'=>'PATCH',
                                'action'=> ['AccountController@updateAccount', $user->slug]]) !!}
                        @include('user.partials._form')
                        {!! Form::close() !!}

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Change Password
                            </div>
                            <div class="panel-body">
                                {!! Form::model($user, ['method'=>'PATCH',
                                                'action'=> ['AccountController@updatePassword', $user->slug]]) !!}
                                @include('user.partials._password')
                                {!! Form::close() !!}
                            </div>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Change Preferences
                            </div>
                            <div class="panel-body">
                                {!! Form::model($user->preferences, ['action'=>['AccountController@updatePreferences', $user->slug],
                                        'method' => 'PATCH']) !!}
                                @include('user.preferences._form')
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection