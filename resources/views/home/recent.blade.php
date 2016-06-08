@extends('layouts.app')

@section('content')
    <div class="col-md-1">
        <p>Recently Updated Galleries</p>
        @if(\App\Gallery::count() > 0)
            <ul>
                @foreach($galleries as $gallery)
                    <li>{{ $gallery->name }}</li>
                @endforeach
            </ul>
        @endif
    </div>
    <div class="col-md-11">
        <div class="container-fluid">
            @foreach($pieces->chunk(4) as $pieceChunk)
                <div class="row">
                    @foreach($pieceChunk as $piece)
                        <div class="col-md-3 vcenter gallery-item">
                            <div class="">
                            <a href="{{ action('PieceController@show', [$piece->featured->first()->gallery_id, $piece->id]) }}">
                                <img src="/{{ $piece->getThumbnail() }}" alt="">
                            </a>
                            </div>
                            <h4><a href="{{ action('PieceController@show', [$piece->featured->first()->gallery_id, $piece->id]) }}">{{ $piece->title }}</a> -
                                <small><a href="{{ action('ProfileController@show', $piece->user->slug) }}">{{ $piece->user->name }}</a></small></h4>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
    {{ $pieces->render() }}
@endsection