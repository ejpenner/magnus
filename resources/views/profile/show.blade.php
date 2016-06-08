@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <h3><img src="{{ $user->getAvatar() }}"> {{ $user->name }}</h3>
        @if(Auth::check() and (Auth::user()->hasRole('admin') or Auth::user()->isOwner($profile)))
            <div class="pull-right"> @include('gallery._createModal') </div>
        @endif
        <p>{{ $profile->biography }}</p>
        <hr>
        <div class="col-md-1">
            <h4>Galleries</h4>
        </div>
        <div class="col-md-10">
            <div class="gallery-container">
                @foreach($galleries->chunk(4) as $i => $gallery)
                    <div class="row">
                        @foreach($gallery as $j => $item)
                            <div class="col-md-3 vcenter gallery-item">
                                @if(isset($item->featured[0]))
                                    <a href="{{ action('GalleryController@show', $item->id) }}">
                                        <img src="/{{ $item->featured->last()->piece->thumbnail_path }}" alt="">
                                    </a>
                                @endif

                                <h4><a href="{{ action('GalleryController@show', $item->id) }}">{{ $item->name }}</a></h4>
                                <p>{{ $item->description }}</p>

                                @if(Auth::check() and (Auth::user()->hasRole('admin') or Auth::user()->isOwner($item)))
                                    <div class="clearfix">
                                        @include('gallery._editModal', ['id'=>$i.'-'.$j, 'gallery'=>$item])
                                        {!! Form::model($item, ['method'=>'delete', 'class'=>'delete-confirm operations', 'action'=>['GalleryController@destroy', $item->id]]) !!}
                                        <button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Delete</button>
                                        {!! Form::close() !!}
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
        <div class="pull-left">
            <div class="container">
                <div class="pull-right">{!! $galleries->render() !!}</div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="col-md-1">
            <h4>Recent Submissions</h4>
        </div>
        <div class="col-md-10">
            @foreach($pieces->chunk(4) as $i => $piecesChunk)
                <div class="row">
                    @foreach($piecesChunk as $piece)
                        <div class="col-md-3 vcenter gallery-item">
                            <a href="{{ action('PieceController@show', [$piece->gallery_id, $piece->id]) }}"><img class="piece-show" src="/{{ $piece->getThumbnail() }}" alt=""></a>
                            <h4><a href="{{ action('PieceController@show', [$piece->gallery_id, $piece->id]) }}">{{ $piece->title }}</a></h4>
                        </div>
                    @endforeach
                </div>
            @endforeach
            <div class="pull-right">{!! $pieces->render() !!}</div>
        </div>
    </div>

@endsection