@extends('layouts.app')

@section('content')
        <div class="col-md-1">
        </div>
        <div class="container-fluid gallery-container col-md-11">
            {{--@foreach($galleries->chunk(4) as $i => $gallery)--}}
                {{--<div class="row">--}}
                    {{--@foreach($gallery as $j => $g)--}}
                        {{--<div class="col-md-3 vcenter gallery-item">--}}

                            {{--@if($g->opera->last()->thumbnail_path != nullOrEmptyString())--}}
                                {{--<a href="{{ action('GalleryController@show', $g->id) }}"><img src="{{ $g->opera->last()->thumbnail_path }}" alt=""></a>--}}
                            {{--@endif--}}

                            {{--<h4><a href="{{ action('GalleryController@show', $g->id) }}">{{ $g->name }}</a></h4>--}}
                            {{--<p>{{ $g->description }}</p>--}}
                            {{--<a href="{{ action('ProfileController@show', $g->user->slug) }}">{{ $g->user->name }}</a>--}}

                            {{--@if(Auth::check() and (Auth::user()->atLeastHasRole(config('roles.administrator')) or Auth::user()->isOwner($g)))--}}
                                {{--<div class="clearfix">--}}
                                    {{--@include('gallery._editModal', ['id'=>$i.'-'.$j, 'gallery'=>$g])--}}
                                    {{--{!! Form::model($item, ['method'=>'delete', 'class'=>'delete-confirm operations', 'action'=>['GalleryController@destroy', $g->id]]) !!}--}}
                                    {{--@if($g->main_gallery != true)--}}
                                        {{--<button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Delete</button>--}}
                                    {{--@endif--}}
                                    {{--{!! Form::close() !!}--}}
                                {{--</div>--}}
                            {{--@endif--}}
                        {{--</div>--}}
                    {{--@endforeach--}}
                {{--</div>--}}
            {{--@endforeach--}}
            @include('partials._galleries', ['galleries' => $galleries])
        </div>
        <div class="container">
            <div class="pull-right">{!! $galleries->render() !!}</div>
        </div>
@stop