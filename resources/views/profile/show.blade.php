@extends('layouts.app')

@section('content')
    @if($user->name != null)
        @include('profile._header', ['profile'=>$profile,'user'=>$user,'details'=>true])
        <div class="container gallery-container">
            <div class="col-md-12">
                @include('partials._galleries', ['galleries' => $galleries])
            </div>
        </div>
        <div class="container gallery-container">
            <a class="btn btn-primary" href="{{ action('ProfileController@galleries', $user->slug) }}">See All Galleries</a>
        </div>
        <div class="container gallery-container">
            <div class="col-md-12">
                @foreach($opera->chunk(4) as $i => $operaChunk)
                    <div class="row">
                        @foreach($operaChunk as $opus)
                            @include('partials._opus', ['opus' => $opus, 'showName' => false])
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
        <div class="container gallery-container">
            <a class="btn btn-primary" href="{{ action('ProfileController@opera', $user->slug) }}">See All Submissions</a>
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
                            @foreach(Magnus::listWatchedUsers($user) as $watcher)
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
                            @foreach(Magnus::listWatchers($user) as $watcher)
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