@extends('layouts.app')

@section('content')
    <div class="col-md-2">
        <h3>{{ $gallery->name }}</h3>
        <p>{{ $gallery->description }}</p>
        <p>Created by <a href="{{ action('ProfileController@show', $gallery->user->slug) }}">{{ $gallery->user->name }}</a></p>

        @if(Auth::check() and (Auth::user()->isOwner($gallery) or Auth::user()->hasRole('admin')))
            <div class="container">
                <a class="btn btn-primary" href="{{ action('PieceController@create', $gallery->id) }}">Submit Artwork</a>
            </div>
        @endif
    </div>
    <div class="col-md-10">
        <div class="container-fluid">
            @foreach($features->chunk(3) as $featureChunk)
                <div class="row" >
                    @foreach($featureChunk as $feature)
                        <div class="vcenter col-md-4 gallery-item">
                            <div class="">
                                <a href="{{ action('PieceController@show', [$feature->gallery->id, $feature->piece->id]) }}">
                                    <img src="/{{ $feature->piece->getThumbnail() }}" alt=""></a>
                                <h4><a href="{{ action('PieceController@show', [$feature->gallery->id, $feature->piece->id]) }}">{{ $feature->piece->title }}</a> -
                                    <small>{{ $feature->piece->user->name }}</small></h4>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
            {{ $features->render() }}
        </div>
    </div>
@endsection