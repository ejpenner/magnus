@extends('layouts.app')

@section('content')
    {!! Form::open(['action'=>['PieceController@store', $gallery->id], 'files'=>true]) !!}
        @include('piece._form')
    {!! Form::close() !!}
@endsection