@extends('layouts.app')

@section('content')
    <div class="col-md-10 col-md-offset-1">
        <div class="container-fluid">
            @foreach($opera->chunk(4) as $operaChunk)
                <div class="row">
                    @foreach($operaChunk as $opus)
                        <div class="col-md-3 vcenter gallery-item">
                            <div class="">
                            <a href="{{ action('OpusController@show', [$opus->id]) }}">
                                <img src="/{{ $opus->getThumbnail() }}" alt="">
                            </a>
                            </div>
                            <h4><a href="{{ action('OpusController@show', [$opus->id]) }}">{{ $opus->title }}</a> -
                                <small><a href="{{ action('ProfileController@show', $opus->user->slug) }}">{{ $opus->user->name }}</a></small></h4>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
    <div class="container">
    <span class="pull-left">{{ $opera->render() }}</span>
    </div>
@endsection