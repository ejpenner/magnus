@extends('layouts.app')

@section('content')
    <div class="container-fluid gallery-container col-md-12">
        @include('partials._galleries', ['galleries' => $galleries, 'columns'=>6])
    </div>
    <div class="container">
        <div class="pull-right">{!! $galleries->render() !!}</div>
    </div>
@stop