@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Change Preferences
                </div>
                <div class="panel-body">
                    @include('user.preferences._form')
                </div>
            </div>
        </div>
    </div>
@endsection