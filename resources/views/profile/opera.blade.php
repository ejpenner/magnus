@extends('layouts.app')

@section('content')
    @include('profile._header', ['user' => $user, 'details' => false])
    <div class="container-fluid">
        <div class="col-lg-2 col-md-2">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="text-center">
                        Galleries
                    </div>
                </div>
                <div class="panel-body gallery-sidebar">
                    @include('partials._galleries', ['galleries' => $user->galleries, 'columns' => 1])
                </div>
            </div>
        </div>
        <div class="col-lg-10 col-md-10">
            @include('partials._opusColumns', ['columns'=>4, 'opera' => $opera])
        </div>
    </div>
    <div class="container">
        <span class="pull-left">{{ $opera->render() }}</span>
    </div>
@endsection