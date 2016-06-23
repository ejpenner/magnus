@extends('layouts.app')

@section('content')
    <div class="container">
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
                    <div class="row">
                        <span class="comment-name">{{ $comment->user->name }}</span>
                        @if($comment->parent_id != null)
                            > <a href="{{ action('CommentController@show', $comment->parent_id) }}">{{ $comment->parentComment->user->name }}</a>
                        @endif
                    </div>
                    <div class="comment-body">
                        <div class="comment-date">{{ $comment->created_at }}</div>
                        <p class="comment-text">{{ $comment->body }}</p>
                    </div>
                </div>
            </div>
        </div>
        @include('comment._commentShow', ['comment'=>$comment])
    </div>
@endsection