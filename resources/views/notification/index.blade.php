@extends('layouts.app')

@section('content')
    <div class="col-md-10 col-md-offset-1">
        <h1>Message Center</h1>
        <div class="panel panel-default">
            <div class="panel-heading">New Submissions</div>
            <div class="panel-body">
                @foreach($opusResults as $opus)
                    <div class="col-md-3 vcenter gallery-item">
                        <div class="">
                            <a href="{{ action('OpusController@show', [$opus->id]) }}">
                                <img src="/{{ $opus->getThumbnail() }}" alt="">
                            </a>
                        </div>
                        <h4><a href="{{ action('OpusController@show', [$opus->id]) }}">{{ $opus->title }}</a> -
                            <small><a href="{{ action('ProfileController@show', $opus->user->slug) }}">{{ $opus->user->name }}</a></small></h4>
                        <div>
                            {!! Form::model($opus, ['method'=>'delete', 'class'=>'delete-confirm operations', 'action'=>['NotificationController@destroy', $opus->notification_id]]) !!}
                            <button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Remove</button>
                            {!! Form::close() !!}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">New Comments</div>
            <div class="panel-body">
                @foreach($commentResults as $comment)
                    <div class="comment-area">
                        <div class="container-fluid comment" id="{{ $comment->id }}">
                            <div class="row">
                                <div class="col-md-2 comment-avatar">
                                    <div class="text-center">
                                        <a href="{{ action('ProfileController@show', $comment->user->slug) }}">
                                            <img src="{{ $comment->user->getAvatar() }}" alt="avatar">
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="row"><span class="comment-name">{{ $comment->user->name }}</span></div>
                                    <div class="comment-body">
                                        <p class="comment-date">{{ $comment->created_at }}</p>
                                        <p>{{ $comment->body }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection