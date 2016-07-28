@extends('layouts.app')

@section('content')
    <div class="col-md-10 col-md-offset-1">
        <h1>Message Center</h1>
        {!! Form::open(['action'=>'NotificationController@destroySelected', 'method'=>'delete']) !!}
        <div class="panel panel-default">
            <div class="panel-heading">
                New Submissions
                <div class="pull-right">
                    <a id="selectAllOpus" class="btn btn-info btn-xs">Select All</a>
                    <button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Remove Selected</button>
                </div>
            </div>
            <div class="panel-body">
                <div class="container-fluid">
                    @foreach($opusResults as $i => $opus)
                        <div class="col-md-3 col-sm-6">
                            <div class="gallery-item message-item">
                                <div class="vcenter">
                                    <a href="{{ action('OpusController@show', [$opus->slug]) }}">
                                        <img src="{{ $opus->getThumbnail() }}" alt="{{ $opus->title }}">
                                    </a>
                                    <h5>
                                        <strong><a href="{{ action('OpusController@show', [$opus->slug]) }}">{{ $opus->title }}</a></strong>
                                        <br>
                                        <a href="{{ action('ProfileController@show', $opus->user->slug) }}">{!! $opus->user->decorateUsername() !!}</a>
                                    </h5>
                                    <div>
                                        <div class="">
                                            {{--<a href="{{ action('NotificationController@destroy', $opus->notification_id) }}" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Remove</a>--}}
                                            <span class="gallery-select">
                                            <input type="checkbox" name="notification_ids[]" id="notification_id_{{$i}}" value="{{ $opus->notification_id }}" class="checkbox-vis-hidden opus-message-select">
                                            <label for="notification_id_{{$i}}"></label>
                                        </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="row">
                    <span class="pull-left">{{ $opusResults->render() }}</span>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
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
                                        <span class="comment-name">{!! $comment->user->decorateUsername() !!}</span>
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
                                    @if($comment->parent_id != null)
                                        <a href="{{ action('CommentController@show', $comment->parent_id) }}">Context</a>
                                    @elseif($comment->commentable instanceOf \Magnus\Journal and $comment->parent_id == null)
                                        <a href="{{ action('JournalController@show', [$comment->user->slug, $comment->commentable->slug]) }}">Context</a>
                                    @elseif($comment->commentable instanceOf \Magnus\Opus and $comment->parent_id == null)
                                        <a href="{{ action('OpusController@show', [$comment->commentable->slug]) }}">Context</a>
                                    @else
                                        {{--no context--}}
                                    @endif

                                </div>
                                <div class="container">
                                    <div class="clearfix">
                                        @include('notification._replyChild', ['comment'=>$comment])
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    {{ $commentResults->render() }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-10 col-lg-offset-1 col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">New Favorites</div>
            <div class="panel-body">
                @foreach($favoriteResults as $favorite)
                    <div class="favorite-notification col-lg-12">
                        <i class="fa fa-heart"></i> <a href="{{ action('ProfileController@show', $favorite->user_slug) }}">{!! Magnus::username($favorite->user_id) !!}</a> has added
                        <a href="{{ action('OpusController@show', $favorite->opus_slug) }}">{{ $favorite->title }}</a> to their favorites
                    </div>
                @endforeach
                {{ $favoriteResults->render() }}
            </div>
        </div>
    </div>
@endsection