@extends('layouts.app')

@section('content')
    <div class="col-md-2">
        <h3>{{ $gallery->name }}</h3>
        <p>{{ $gallery->description }}</p>
        <p>Created by <a href="{{ action('ProfileController@show', $gallery->user->slug) }}">{{ $gallery->user->name }}</a></p>

        @if(Auth::check() and (Auth::user()->isOwner($gallery) or Auth::user()->hasRole('admin')))
            <div class="container">
                <a class="btn btn-primary" href="{{ action('OpusController@create') }}">Submit Artwork</a>
            </div>
        @endif
    </div>
    <div class="col-md-10">
        <div class="container-fluid">
            @foreach($opera->chunk(3) as $opusChunk)
                <div class="row" >
                    @foreach($opusChunk as $opus)
                        <div class="vcenter col-md-4 gallery-item">
                            <div class="">
                                <a href="{{ action('OpusController@galleryShow', [$gallery->id, $opus->id]) }}">
                                    <img src="/{{ $opus->getThumbnail() }}" alt=""></a>
                                <h4><a href="{{ action('OpusController@galleryShow', [$gallery->id, $opus->id]) }}">{{ $opus->title }}</a> -
                                    <small>{{ $opus->user->name }}</small></h4>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
            {{ $opera->render() }}
        </div>
    </div>
@endsection