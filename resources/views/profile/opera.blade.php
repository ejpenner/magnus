@extends('layouts.app')

@section('content')
    @include('profile._header', ['user'=>$user, 'details'=>false])
    <div class="container-fluid">
        @include('partials._opusColumns', ['columns'=>6, 'opera' => $opera])
    </div>
    <div class="container">
        <span class="pull-left">{{ $opera->render() }}</span>
    </div>
@endsection