@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                Change User Settings
            </div>
            <div class="panel-body">
                {!! Form::model($user, ['method'=>'PATCH',
                        'action'=> ['UserController@updateAccount', $user->id]]) !!}
                @include('user._form')
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection