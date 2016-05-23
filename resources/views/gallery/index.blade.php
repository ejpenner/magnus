@extends('layouts.app')

@section('content')
    <div class="container">
        @foreach($galleries as $gallery)
            <div class="col-md-3 gallery-item">
                {{ $gallery->name }}
                {{ $gallery->description }}
                @include('partials._operations', ['model' => $gallery, 'controller'=>'GalleryController'])
            </div>
        @endforeach
        <div class="pull-left"> @include('gallery._createModal') </div>
        <div class="pull-right">{!! $galleries->render() !!}</div>
    </div>

@stop