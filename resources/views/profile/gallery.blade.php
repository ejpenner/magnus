@extends('layouts.app')

@section('content')
    <div class="col-md-2">
        @include('gallery._createModal')
    </div>
    <div class="container-fluid gallery-container col-md-10">
        @foreach($galleries->chunk(4) as $i => $gallery)
            <div class="row">
                @foreach($gallery as $j => $item)
                    <div class="col-md-3 vcenter gallery-item">
                        @if($item->opera->count() > 0)
                            <a href="{{ action('GalleryController@show', $item->id) }}"><img src="{{ $item->opera->last()->thumbnail_path }}" alt=""></a>
                        @endif

                        <h5><a href="{{ action('GalleryController@show', $item->id) }}">{{ $item->name }}</a></h5>
                        <p>{{ $item->description }}</p>
                        <a href="{{ action('ProfileController@show', $item->user->slug) }}">{{ $item->user->name }}</a>

                        @if(Auth::check() and (Auth::user()->atLeastHasRole(Config::get('roles.gmod-code')) or Auth::user()->isOwner($item)))
                            <div class="clearfix">
                                @include('gallery._editModal', ['id'=>$i.'-'.$j, 'gallery'=>$item])
                                {!! Form::model($item, ['method'=>'delete', 'class'=>'delete-confirm operations', 'action'=>['GalleryController@destroy', $item->id]]) !!}
                                @if($item->main_gallery != true)
                                    <button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Delete</button>
                                @endif
                                {!! Form::close() !!}
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endforeach

    </div>
    <div class="container">
        <div class="pull-right">{!! $galleries->render() !!}</div>
    </div>
@stop