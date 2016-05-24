@extends('layouts.app')

@section('content')
    <div class="container gallery-container">
        @foreach($galleries as $gallery)
            <div class="col-md-3 gallery-item">
                {{ $gallery->name }}
                {{ $gallery->description }}<br>
                <a href="{{ action('ProfileController@show', $gallery->user->slug) }}">{{ $gallery->user->name }}</a>
                <span class="pull-right"> @include('partials._operations', ['model' => $gallery, 'controller'=>'GalleryController']) </span>
            </div>
        @endforeach
    </div>
    <div class="container">
        <div class="pull-left"> @include('gallery._createModal') </div>
        <div class="pull-right">{!! $galleries->render() !!}</div>
    </div>

@stop