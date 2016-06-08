@extends('layouts.app')

@section('content')
        <div class="container-fluid gallery-container">

            @foreach($galleries->chunk(4) as $i => $gallery)
                <div class="row">
                    @foreach($gallery as $j => $item)
                        <div class="col-md-3 vcenter gallery-item">

                            @if(isset($item->featured[0]))
                                <a href="{{ action('GalleryController@show', $item->id) }}"><img src="{{ $item->featured->last()->piece->thumbnail_path }}" alt=""></a>
                            @endif

                            <h4><a href="{{ action('GalleryController@show', $item->id) }}">{{ $item->name }}</a></h4>
                            <p>{{ $item->description }}</p>
                            <a href="{{ action('ProfileController@show', $item->user->slug) }}">{{ $item->user->name }}</a>

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
        <div class="container">
            <div class="pull-right">{!! $galleries->render() !!}</div>
        </div>
@stop