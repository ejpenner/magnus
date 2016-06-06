@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <h3><img src="{{ $user->getAvatar() }}"> {{ $user->name }}</h3>
        <p>{{ $profile->biography }}</p>
        <hr>
        <div class="gallery-container">
            @foreach($galleries->chunk(4) as $i => $gallery)
                <div class="row">
                    @foreach($gallery as $j => $item)
                        <div class="col-md-3 vcenter gallery-item">

                            @if(isset($item->featured[0]))
                                <img src="/{{ $item->featured->last()->piece->thumbnail_path }}" alt="">
                            @endif

                            <h4><a href="{{ action('GalleryController@show', $item->id) }}">{{ $item->name }}</a></h4>
                            <p>{{ $item->description }}</p>

                            @if(Auth::check() and (Auth::user()->hasRole('admin') or Auth::user()->isOwner($item)))
                                <div class="clearfix">
                                    @include('gallery._editModal', ['id'=>$i.'-'.$j, 'gallery'=>$item])
                                    {!! Form::model($item, ['method'=>'delete', 'class'=>'delete-confirm operations', 'action'=>['GalleryController@destroy', $item->id]]) !!}
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Delete</button>
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
            @if(Auth::check() and (Auth::user()->hasRole('admin') or Auth::user()->isOwner($profile)))
                <div class="pull-left"> @include('gallery._createModal') </div>
            @endif
            <div class="pull-right">{!! $galleries->render() !!}</div>
        </div>
    </div>
@endsection