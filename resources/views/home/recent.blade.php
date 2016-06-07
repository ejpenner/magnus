@extends('layouts.app')

@section('content')
    <div class="col-md-1">
        Side
    </div>
    <div class="col-md-11">
        <div class="container-fluid">
            @foreach($pieces->chunk(4) as $pieceChunk)
                <div class="row">
                    @foreach($pieceChunk as $piece)
                        <div class="col-md-3 vcenter gallery-item">
                            <a href="{{ action('PieceController@show', [$piece->featured->first()->gallery_id, $piece->id]) }}">
                                <img src="/{{ $piece->getThumbnail() }}" alt="">
                            </a>
                            <h4><a href="{{ action('PieceController@show', [$piece->featured->first()->gallery_id, $piece->id]) }}">{{ $piece->title }}</a>- {{ $piece->user->name }}</h4>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
    {{ $pieces->render() }}
@endsection