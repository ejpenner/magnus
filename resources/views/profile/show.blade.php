@extends('layouts.app')

@section('title')
    {{ $user->username }} -
@endsection
@section('content')
    <div class="container-fluid">
        @include('profile._header', ['profile'=>$profile,'user'=>$user,'details'=>true])
        <div class="col-lg-6 col-md-12">
            <div class="panel panel-default profile-opus-panel"> {{-- opus panel --}}
                <div class="panel-heading">
                    <h4 class="panel-title">Recent Submissions</h4>
                </div>
                <div class="panel-body">
                    <div class="gallery-container">
                        <div class="col-md-12">
                            @include('partials._opusColumns', ['columns' => 2, 'opera' => $opera])
                        </div>
                    </div>
                    <div class="gallery-container">
                        <a class="btn btn-primary btn-lg pull-right" href="{{ action('ProfileController@opera', $user->slug) }}">See more</a>
                    </div>
                </div>
            </div>

            <div class="panel panel-default profile-favorites-panel"> {{-- favorites panel --}}
                <div class="panel-heading">
                    <h4 class="panel-title">Favorites</h4>
                </div>
                <div class="panel-body">
                    <div class="col-md-12 gallery-container">
                        @include('profile._favorites', ['columns' => 2, 'opera' => $favorites])
                    </div>
                    <div class="gallery-container">
                        <a class="btn btn-primary btn-lg pull-right" href="{{ action('ProfileController@favorites', $user->slug) }}">See more</a>
                    </div>
                </div>
            </div>
            {{--<div class="panel panel-default profile-gallery-panel"> --}}{{-- gallery panel --}}
            {{--<div class="panel-heading">--}}
            {{--Galleries--}}
            {{--</div>--}}
            {{--<div class="panel-body">--}}
            {{--<div class="gallery-container">--}}
            {{--<div class="col-md-12">--}}
            {{--@include('partials._galleries', ['galleries' => $galleries, 'columns' => 2])--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--<div class="gallery-container">--}}
            {{--<a class="btn btn-primary" href="{{ action('ProfileController@galleries', $user->slug) }}">See more</a>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</div>--}}
        </div>
        <div class="col-lg-6 col-md-12">
            @include('profile._journal', ['user'=>$user, 'journal' => $journal])
        </div>
    </div>
    <div class="container-fluid">
        <div class="col-lg-6 col-md-12">
            <div class="panel panel-default"> {{-- Watching panel --}}
                <div class="panel-heading">
                    <h4 class="panel-title">Watching
                    <a class="btn btn-xs btn-primary btn-lg pull-right" href="{{ action('ProfileController@watching', $user->slug) }}">Full list</a>
                    </h4>
                </div>
                <div class="panel-body">
                    <ul>
                        @foreach(Magnus::listWatchedUsers($user) as $watcher)
                            <li><a href="{{ action('ProfileController@show', $watcher->slug) }}">{{ $watcher->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-12">
            <div class="panel panel-default"> {{-- watchers panel --}}
                <div class="panel-heading">
                    <h4 class="panel-title">Watchers
                    <a class="btn btn-xs btn-primary btn-lg pull-right" href="{{ action('ProfileController@watchers', $user->slug) }}">Full list</a>
                    </h4>
                </div>
                <div class="panel-body">
                    <ul>
                        @foreach(Magnus::listWatchers($user) as $watcher)
                            <li><a href="{{ action('ProfileController@show', $watcher->slug) }}">{{ $watcher->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection