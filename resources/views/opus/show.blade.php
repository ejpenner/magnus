@extends('layouts.app')

@section('content')
    <div class="col-md-12">
        <div class="text-center">
            <div class="container-fluid">
                @include('opus.partials._image', ['opus' => $opus, 'metadata'=>$metadata])
            </div>
        </div>
        @include('opus.partials._navigator', ['navigator' => $navigator])
        {{--panel start--}}
        @include('opus.partials._opusDetails', ['opus' => $opus, 'metadata' => $metadata, 'favoriteCount' => $favoriteCount])
        <div class="container-fluid">
            <div class="col-md-offset-2 col-md-8">
                @include('comment._commentOpus', ['comments'=>$opus->comments, 'opus'=>$opus])
            </div>
        </div>
    </div>
@endsection