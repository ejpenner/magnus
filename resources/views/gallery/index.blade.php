@extends('layouts.app')

@section('content')
{{--    {{ dd(Auth::user()->permissions) }}--}}
    <div class="container gallery-container">
        @foreach($galleries as $gallery)
            <div class="col-md-3 gallery-item">
                {{ $gallery->name }}
                {{ $gallery->description }}<br>
                <a href="{{ action('ProfileController@show', $gallery->user->slug) }}">{{ $gallery->user->name }}</a>
                @if(Auth::check() and (Auth::user()->hasRole('admin') or Auth::user()->isOwner($gallery)))
                    <span class="pull-right"> @include('partials._operations', ['model' => $gallery, 'controller'=>'GalleryController']) </span>
                @endif
            </div>
        @endforeach
    </div>
    <div class="container">
        @if(Auth::check() and Auth::user()->hasRole('admin'))
            <div class="pull-left"> @include('gallery._createModal') </div>
        @endif
        <div class="pull-right">{!! $galleries->render() !!}</div>
    </div>

@stop