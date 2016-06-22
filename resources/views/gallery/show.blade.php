@extends('layouts.app')

@section('content')
    <div class="col-md-2">
        <h3>{{ $gallery->name }}</h3>
        <p>{{ $gallery->description }}</p>
        <p>Created by <a href="{{ action('ProfileController@show', $gallery->user->slug) }}">{{ $gallery->user->name }}</a></p>

        @if(Auth::check() and (Auth::user()->isOwner($gallery) or Auth::user()->atLeastHasRole(config('roles.globalModerator'))))
            <div class="container">
                <a class="btn btn-primary" href="{{ action('OpusController@newSubmission') }}">Submit Artwork</a>
            </div>
        @endif
    </div>
    <div class="col-md-10">
        <div class="container-fluid">
            @foreach($opera->chunk(4) as $opusChunk)
                <div class="row" >
                    @foreach($opusChunk as $opus)
                        @include('partials._opusGallery', ['opus'=>$opus, 'gallery'=>$gallery])
                    @endforeach
                </div>
            @endforeach
            {{ $opera->render() }}
        </div>
    </div>
@endsection