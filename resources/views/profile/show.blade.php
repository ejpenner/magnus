@extends('layouts.app')

@section('content')
    @if($user->name != null)
    <div class="container-fluid">
        @include('profile._header', ['profile'=>$profile,'user'=>$user])
        <div class="col-md-2">
            <h4>Galleries</h4>
            <a class="btn btn-lg btn-primary" href="{{ action('ProfileController@galleries', $user->slug) }}">See All</a>
        </div>
        <div class="col-md-10">
            <div class="gallery-container">
                @include('partials._galleries', ['galleries' => $galleries])
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="col-md-2">
            <h4>Recent Submissions</h4>
            <a class="btn btn-lg btn-primary" href="{{ action('ProfileController@opera', $user->slug) }}">See All Submissions</a>
        </div>
        <div class="col-md-10">
            @foreach($opera->chunk(4) as $i => $operaChunk)
                <div class="row">
                    @foreach($operaChunk as $opus)
                        @include('partials._opus', ['opus' => $opus, 'showName' => false])
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
    <div class="container">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Watching
                    <a class="btn btn-xs btn-primary pull-right" href="{{ action('ProfileController@watching', $user->slug) }}">Full list</a>
                </div>
                <div class="panel-body">
                    <ul>
                        @foreach($user->listWatchedUsers() as $watcher)
                            <li><a href="{{ action('ProfileController@show', $watcher->slug) }}">{{ $watcher->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Watchers
                    <a class="btn btn-xs btn-primary pull-right" href="{{ action('ProfileController@watchers', $user->slug) }}">Full list</a>
                </div>
                <div class="panel-body">
                    <ul>
                        @foreach($user->listWatchers() as $watcher)
                            <li><a href="{{ action('ProfileController@show', $watcher->slug) }}">{{ $watcher->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @else
        <div class="container">
            <h2>Profile does not exist</h2>
        </div>
    @endif
@endsection