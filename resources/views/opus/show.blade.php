@extends('layouts.app')

@section('content')
    <div class="col-md-12">
        <div class="text-center">
            <div class="piece-display">
                <img class="piece-show" src="/{{ $opus->getImage() }}" alt="">
            </div>
            @if(isset($galleryNav))
            <div class="text-center">
                <div class="piece-nav">
                    <div class="btn-group">
                        <a class="btn btn-default" href="{{ action('OpusController@show', $galleryNav['previous']) }}">Previous</a>
                        <a class="btn btn-default" href="{{ action('GalleryController@show', [$gallery->id]) }}">Gallery</a>
                        <a class="btn btn-default" href="{{ action('OpusController@show', $galleryNav['next']) }}">Next</a>
                    </div>
                </div>
            </div>
            @endif
        </div>
        {{--panel start--}}
        <div class="container">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="piece-info">
                        <div class="container-fluid">
                            <div class="col-md-9">
                                <a href="{{ action('ProfileController@show', $opus->user->slug) }}">
                                    <img src="{{ $opus->user->getAvatar() }}" class="pull-left avatar" alt="avatar">
                                </a>
                                <h3>{{ $opus->title }}</h3>
                                <p>By <a href="{{ action('ProfileController@show', $opus->user->slug) }}">{{ $opus->user->name }}</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @unless($opus->tags->isEmpty())
                            <div class="container-fluid">
                                <ul class="list-inline">
                                    <strong>Tags</strong>
                                    @foreach($opus->tags as $tag)
                                        <li><a href="{{ action('SearchController@searchAll', '@'.$tag->name) }}">{{ $tag->name }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        @endunless
                    </div>
                    <div class="well col-md-9">
                        <p>{{ $opus->comment }}</p>
                    </div>
                    <div class="col-md-3">
                        <div class="panel panel-default details-panel">
                            <div class="panel-heading">
                                Details
                                @if(Auth::check() and (Auth::user()->isOwner($opus) or Auth::user()->hasRole('admin')))
                                    <div class="pull-right operations">
                                        {!! Form::model($opus, ['method'=>'delete', 'class'=>'delete-confirm operations',
                                                               'action'=>['OpusController@destroy', $opus->id]]) !!}
                                        <a href="{{ action('OpusController@edit', [$opus->id]) }}">
                                            <button type="button" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i> Edit</button>
                                        </a>
                                        <button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Delete</button>
                                        {!! Form::close() !!}
                                    </div>
                                @endif
                            </div>
                            <table class="table">
                                <tbody>
                                <tr>
                                    <td>Views</td>
                                    <td>{{ $opus->views }}</td>
                                </tr>
                                <tr>
                                    <td>Submitted On</td>
                                    <td>{{ $opus->published_at }}</td>
                                </tr>
                                <tr>
                                    <td>Image Size</td>
                                    <td>{{ $metadata['filesize'] }}</td>
                                </tr>
                                <tr>
                                    <td>Resolution</td>
                                    <td>{{ $metadata['resolution'] }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="col-md-offset-2 col-md-8">
                @include('comment._comment', ['comments'=>$opus->comments, 'gallery'=>$gallery, 'opus'=>$opus])
            </div>
        </div>
    </div>
@endsection