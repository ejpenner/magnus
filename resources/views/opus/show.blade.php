@extends('layouts.app')

@section('content')
    <div class="col-lg-10">
            <div class="container">
                <div class="text-center">
                    @include('opus.partials._image', ['opus' => $opus, 'metadata'=>$metadata])
                </div>

            </div>
        {{--panel start--}}
        @include('opus.partials._opusDetails', ['opus' => $opus, 'metadata' => $metadata, 'favoriteCount' => $favoriteCount, 'navigator' => $navigator])
        <div class="container-fluid">
            <div class="col-md-8">
                @include('comment._commentOpus', ['comments'=>$opus->comments, 'opus'=>$opus])
            </div>
        </div>
    </div>
    <div class="opus-sidebar">
        <div class="col-lg-2 opus-sidebar">
            Sidebar
        </div>
    </div>
@endsection