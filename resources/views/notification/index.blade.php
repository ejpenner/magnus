@extends('layouts.app')

@section('content')
    <div class="col-md-10 col-md-offset-1">
        <h1>Message Center</h1>
        <div class="panel panel-default">
            <div class="panel-heading">New Submissions</div>
            <div class="panel-body">
                <div class="container-fluid">
                    {!! Form::open(['action'=>'NotificationController@destroySelected', 'method'=>'delete']) !!}
                    @foreach($opusResults as $i => $opus)
                        <div class="col-md-3 col-sm-6">
                            <div class="gallery-item message-item">
                                <div class="vcenter">
                                    <a href="{{ action('OpusController@show', [$opus->id]) }}">
                                        <img src="/{{ $opus->getThumbnail() }}" alt="">
                                    </a>
                                    <h5>
                                        <strong><a href="{{ action('OpusController@show', [$opus->id]) }}">{{ $opus->title }}</a></strong>
                                        <br>
                                        <a href="{{ action('ProfileController@show', $opus->user->slug) }}">{!! $user->decorateUsername() !!}</a>
                                    </h5>
                                    <div>
                                        <a href="{{ action('NotificationController@destroy', $opus->notification_id) }}" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Remove</a>
                                        <div class="gallery-select">
                                            <input type="checkbox" name="notification_ids[]" id="notification_id_{{$i}}" value="{{ $opus->notification_id }}" class="checkbox-vis-hidden">
                                            <label for="notification_id_{{$i}}"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Remove Selected</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">New Comments</div>
            <div class="panel-body">
                <div class="container">
                    @foreach($commentResults as $comment)
                        <div class="comment-area">
                            <div class="container-fluid comment" id="{{ $comment->id }}">
                                <div class="col-md-2 comment-avatar">
                                    <div class="text-center">
                                        <a href="{{ action('ProfileController@show', $comment->user->slug) }}">
                                            <img src="{{ $comment->user->getAvatar() }}" alt="avatar">
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="row">
                                        <span class="comment-name">{{ $comment->user->name }}</span>
                                            <span class="pull-right comment-delete-notification">
                                                {!! Form::model($comment, ['method'=>'delete', 'class'=>'delete-confirm operations', 'action'=>['NotificationController@destroy', $comment->notification_id]]) !!}
                                                <button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Remove</button>
                                                {!! Form::close() !!}
                                            </span>
                                    </div>
                                    <div class="comment-body">
                                        <div class="comment-date">{{ $comment->created_at }}</div>
                                        <p class="comment-text">{{ $comment->body }}</p>
                                    </div>
                                </div>
                                <div class="container">
                                    <div class="clearfix">
                                        @include('notification._replyChild', ['comment'=>$comment])
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection