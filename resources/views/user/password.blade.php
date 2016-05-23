@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="page-header col-md-8 col-md-offset-2">
            <h1>{{ $user->name }}</h1>
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading clearfix">
                        <h1 class="panel-title pull-left">Change Password</h1>
                    </div>
                    <div class="panel-body">
                        {!! Form::model($user, [
                        'method' => 'PATCH',
                        'action' => [
                        'UsersController@updatePassword',
                        $user->id
                        ],
                        'class' => 'user-form'
                        ]) !!}
                        @include ('users.formPassword', ['submitButtonText' => 'Save'])
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection