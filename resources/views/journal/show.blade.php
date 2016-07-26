@extends('layouts.app')

@section('content')
    @include('profile._header', ['profile'=>$profile,'user'=>$user,'details'=>false])
@endsection