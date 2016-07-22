@extends('layouts.app')
@section('content')
    <div class="col-lg-6 col-lg-offset-3 col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Users who have added <a href="{{ action('OpusController@show', $opus->slug) }}">{{ $opus->title }}</a> to their favorites
            </div>
            <div class="panel-body">
                <ol>
                    @foreach($users as $user)
                        <li>
                            <a href="{{ action('ProfileController@show', $user->slug) }}">{!! $user->decorateUsername() !!}</a>
                            <span class="watch-date">added on {{ date_format($user->pivot->created_at, 'M j, Y g:i A') }}</span>
                        </li>
                    @endforeach
                </ol>
            </div>
        </div>
    </div>
@endsection