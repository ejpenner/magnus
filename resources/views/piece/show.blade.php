@extends('layouts.app')

@section('content')
    <div class="col-md-12">
        <div class="text-center">
            <div class="piece-display">
                <img class="piece-show" src="/{{ $piece->getImage() }}" alt="">
            </div>
            <div class="text-center">
                <div class="piece-nav">
                    <div class="btn-group">
                        <a class="btn btn-default" href="{{ action('PieceController@show', [$gallery->id, $galleryNav['previous']]) }}">Previous</a>
                        <a class="btn btn-default" href="{{ action('GalleryController@show', [$gallery->id]) }}">Gallery</a>
                        <a class="btn btn-default" href="{{ action('PieceController@show', [$gallery->id, $galleryNav['next']]) }}">Next</a>
                    </div>
                </div>
            </div>
        </div>
        {{--panel start--}}
        <div class="container">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="piece-info">
                        <div class="container-fluid">
                            <div class="col-md-9">
                                <a href="{{ action('ProfileController@show', $piece->user->slug) }}">
                                    <img src="{{ $piece->user->getAvatar() }}" class="pull-left avatar" alt="avatar">
                                </a>
                                <h3>{{ $piece->title }}</h3>
                                <p>By <a href="{{ action('ProfileController@show', $piece->user->slug) }}">{{ $piece->user->name }}</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @unless($piece->tags->isEmpty())
                            <div class="container-fluid">

                                <ul class="list-inline">
                                    <strong>Tags</strong>
                                    @foreach($piece->tags as $tag)
                                        <li><a href="{{ action('SearchController@searchAll', '@'.$tag->name) }}">{{ $tag->name }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        @endunless
                    </div>
                    <div class="well col-md-9">
                        <p>{{ $piece->comment }}</p>
                    </div>
                    <div class="col-md-3">
                        <div class="panel panel-default details-panel">
                            <div class="panel-heading">
                                Details
                                @if(Auth::check() and (Auth::user()->isOwner($piece) or Auth::user()->hasRole('admin')))
                                    <div class="pull-right operations">
                                        {!! Form::model($piece, ['method'=>'delete', 'class'=>'delete-confirm operations',
                                                               'action'=>['PieceController@destroy', $gallery->id, $piece->id]]) !!}
                                        <a href="{{ action('PieceController@edit', [$gallery->id, $piece->id]) }}">
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
                                    <td>{{ $piece->views }}</td>
                                </tr>
                                <tr>
                                    <td>Submitted On</td>
                                    <td>{{ $piece->published_at }}</td>
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
            @include('comment._comment', ['comments'=>$piece->comments, 'gallery'=>$gallery, 'piece'=>$piece])
            </div>
        </div>
    </div>
@endsection