@extends('layouts.app')

@section('content')
    <div class="container gallery-container">
        @foreach($galleries as $i => $gallery)
            <div class="col-md-3 gallery-item">
                <a href="{{ action('GalleryController@show', $gallery->id) }}">{{ $gallery->name }}</a>
                {{ $gallery->description }}<br>
                <a href="{{ action('ProfileController@show', $gallery->user->slug) }}">{{ $gallery->user->name }}</a>

                @if(Auth::check() and (Auth::user()->hasRole('admin') or Auth::user()->isOwner($gallery)))
                    {{--<span class="pull-right"> @include('partials._operations', ['model' => $gallery, 'controller'=>'GalleryController']) </span>--}}
                    <div class="clearfix">
                        @include('gallery._editModal', ['id'=>$i, 'model'=>$gallery])
                        {!! Form::model($gallery, ['method'=>'delete', 'class'=>'delete-confirm operations', 'action'=>['GalleryController@destroy', $gallery->id]]) !!}
                        <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Delete</button>
                        {!! Form::close() !!}
                    </div>

                @endif

            </div>
        @endforeach
    </div>
    <div class="container">
        @if(Auth::check() and Auth::user()->hasRole('admin'))
            <div class="pull-left"> @include('gallery._createModal') </div>
        @endif
        <div class="pull-right">{!! $galleries->render() !!}</div>
    </div>

@stop