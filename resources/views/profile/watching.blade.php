@extends('layouts.app')

@section('content')
    @if($user->name != null)
        @include('profile._header', ['user' => $user])
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">Watched Users</div>
                <div class="panel-body">
                    <ul>
                        @foreach($watchers as $watcher)
                            <li><a href="{{ action('ProfileController@show', $watcher->slug) }}">{{ $watcher->name }}</a>
                                <div class="pull-right watch-date">
                                    since {{ $user->created_at->format('F d, Y') }}
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            {{ $watchers->render() }}
        </div>
    @else
        <h3>User not found</h3>
    @endif
@endsection