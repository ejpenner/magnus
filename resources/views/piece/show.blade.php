@extends('layouts.app')

@section('content')
    <div class="col-md-2">

    </div>
    <div class="col-md-8">
        <div class="piece-display">
            <img class="piece-show" src="/{{ $piece->getImage() }}" alt="">
        </div>
        <div class="piece-info">
            <div class="container-fluid">
                <a href="{{ action('ProfileController@show', $piece->user->slug) }}"><img src="{{ $piece->user->getAvatar() }}" class="pull-left avatar" alt="avatar"></a>
                <h3>{{ $piece->title }}</h3>
                <p>By <a href="{{ action('ProfileController@show', $piece->user->slug) }}">{{ $piece->user->name }}</a></p>
            </div>
        </div>
        <div class="container">
            <div class="well col-md-9">
                <p>{{ $piece->comment }}</p>
            </div>
            <div class="col-md-3">
                @unless($piece->tags->isEmpty())
                    <div class="container-fluid">
                        <h4>Tags:</h4>
                        <ul class="list-inline">
                            @foreach($piece->tags as $tag)
                                <li><a href="{{ action('SearchController@searchAll', $tag->name) }}">{{ $tag->name }}</a></li>
                            @endforeach
                        </ul>
                        @if(Auth::check() and (Auth::user()->isOwner($piece) or Auth::user()->hasRole('admin')))
                            <div class="pull-left operations">
                                {!! Form::model($piece, ['method'=>'delete', 'class'=>'delete-confirm operations',
                                                       'action'=>['PieceController@destroy', $gallery->id, $piece->id]]) !!}
                                <a href="{{ action('PieceController@edit', [$gallery->id, $piece->id]) }}">
                                    <button type="button" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</button>
                                </a>
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Delete</button>
                                {!! Form::close() !!}
                            </div>
                        @endif
                    </div>
                @endunless
                <table class="table">
                    <thead>
                    <tr>
                        <th>Submission Details</th>
                        <th>&nbsp</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Submitted On</td>
                        <td class="pull-right">{{ $piece->published_at }}</td>
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
@endsection