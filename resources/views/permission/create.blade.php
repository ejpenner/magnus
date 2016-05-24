@extends('layouts.app')

@section('content')
        {!! Form::open(['action' => ['PermissionController@store']]) !!}
            @include('permission._form')
        {!! Form::close() !!}
@endsection