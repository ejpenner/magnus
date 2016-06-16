@extends('layouts.app')

@section('content')
    @if($results->count() > 0)
        <div class="container-fluid">
            <h4>Search results for: <small>{{ urldecode(substr(Request::path(), 7)) }}</small></h4>
        </div>
        <div class="text-center">
            @foreach($results->chunk(4) as $resultChunk)
                <div class="row">
                    @foreach($resultChunk as $result)
                        <div class="col-md-3 vcenter gallery-item">
                            <a href="{{ action('OpusController@show', [$result->id]) }}">
                                <img src="/{{ $result->getThumbnail() }}" alt="">
                            </a>
                            <h4><a href="{{ action('OpusController@show', [$result->id]) }}">{{ $result->title }}</a> -
                                <small><a href="{{ action('ProfileController@show', $result->user->slug) }}">{{ $result->user->name }}</a></small></h4>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
        <div class="container">
            {{ $results->render() }}
        </div>
    @else
        <div class="container">
            <p>No results found.</p>
        </div>
    @endif
@endsection