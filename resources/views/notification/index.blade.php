@extends('layouts.app')

@section('content')
    <h2>Message Center</h2>
    <div class="container-fluid">
        <h3>New Submissions</h3>
        <div class="container-fluid">
            @foreach($opusResults as $opus)
                <div class="col-md-3 vcenter gallery-item">
                    <div class="">
                        <a href="{{ action('OpusController@show', [$opus->id]) }}">
                            <img src="/{{ $opus->getThumbnail() }}" alt="">
                        </a>
                    </div>
                    <h4><a href="{{ action('OpusController@show', [$opus->id]) }}">{{ $opus->title }}</a> -
                        <small><a href="{{ action('ProfileController@show', $opus->user->slug) }}">{{ $opus->user->name }}</a></small></h4>
                    <div>{{ $opus->notification_id }}</div>
                    <div>
                        {!! Form::model($opus, ['method'=>'delete', 'class'=>'delete-confirm operations', 'action'=>['NotificationController@destroy', $opus->notification_id]]) !!}
                            <button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Remove</button>
                        {!! Form::close() !!}
                    </div>
                </div>
            @endforeach
        </div>
        <div class="col-md-8">
            <table class="table">
                <thead>
                <tr>
                    <th>
                        Messages
                    </th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
@endsection