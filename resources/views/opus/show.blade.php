@extends('layouts.app')

@section('content')
    <div class="opus-main">
        <div id="opus-image">
            @include('opus.partials._image', ['opus' => $opus, 'metadata'=>$metadata])
        </div>
        <div class="text-center watch-date">
            {{ $opus->published() }}
        </div>
        {{--<div class="opus-sidebar">--}}
            {{--<div class="sidebar-content">--}}
                {{--@include('opus.partials._navigator', ['navigator' => $navigator])--}}
                {{--@include('opus.partials._favoriteButton', ['opus' => $opus])--}}
            {{--</div>--}}
        {{--</div>--}}
        <div class="opus-panel">
            {{--panel start--}}
            @include('opus.partials._opusDetails', ['opus' => $opus, 'metadata' => $metadata, 'favoriteCount' => $favoriteCount])
            <div class="container-fluid">
                <div class="col-md-8">
                    @include('comment._commentOpus', ['comments'=>$opus->comments, 'opus'=>$opus])
                </div>
            </div>
        </div>
    </div>
@endsection