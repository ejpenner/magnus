@extends('layouts.app')

@section('content')
    @if($results->count() > 0)
        @foreach($results->chunk(4) as $resultChunk)
            <div class="row">
                @foreach($resultChunk as $result)
                    <div class="col-md-3">
                        <img src="/{{ $result->getThumbnail() }}" alt="">
                        <h4><a href="{{ action('PieceController@show', [$result->gallery_id, $result->id]) }}">{{ $result->title }}</a> -
                            <a href="{{ action('ProfileController@show', $result->user->slug) }}">{{ $result->user->name }}</a></h4>
                    </div>
                @endforeach
            </div>
        @endforeach
        {{ $results->render() }}
    @else
        <div class="container">
            <p>No results found.</p>
        </div>
    @endif
@endsection