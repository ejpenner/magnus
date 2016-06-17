@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        @include('profile._header', ['profile'=>$profile,'user'=>$user])
        <div class="col-md-2">
            <h4>Galleries</h4>
            <a class="btn btn-lg btn-primary" href="{{ action('ProfileController@galleries', $user->slug) }}">See All</a>
        </div>
        <div class="col-md-10">
            <div class="gallery-container">
                @foreach($galleries->chunk(4) as $i => $gallery)
                    <div class="row">
                        @foreach($gallery as $j => $item)
                            <div class="col-md-3 vcenter gallery-item">

                                @if(isset($item->opera->first()->thumbnail_path))
                                    <a href="{{ action('GalleryController@show', $item->id) }}">
                                        <img src="/{{ $item->opera->first()->thumbnail_path }}" alt="">
                                    </a>
                                @endif

                                <h4><a href="{{ action('GalleryController@show', $item->id) }}">{{ $item->name }}</a></h4>
                                <p>{{ $item->description }}</p>

                                @if(Auth::check() and (Auth::user()->hasRole('admin') or Auth::user()->isOwner($item)))
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
        </div>
    </div>
    <div class="container-fluid">
        <div class="col-md-2">
            <h4>Recent Submissions</h4>
            <a class="btn btn-lg btn-primary" href="{{ action('ProfileController@opera', $user->slug) }}">See All Submissions</a>
        </div>
        <div class="col-md-10">
            @foreach($opera->chunk(4) as $i => $operaChunk)
                <div class="row">
                    @foreach($operaChunk as $opus)
                        <div class="col-md-3 vcenter gallery-item">
                            <a href="{{ action('OpusController@show', [$opus->id]) }}"><img class="piece-show" src="/{{ $opus->getThumbnail() }}" alt=""></a>
                            <h4><a href="{{ action('OpusController@show', [$opus->id]) }}">{{ $opus->title }}</a></h4>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
    <div class="container">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Watched Users</div>
                <div class="panel-body">
                    <ul>
                        @foreach($profile->listWatchedUsers() as $watcher)
                            <li><a href="{{ action('ProfileController@show', $watcher['slug']) }}">{{ $watcher['name'] }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Watchers</div>
                <div class="panel-body">
                    <ul>
                        @foreach($profile->listWatchers() as $watcher)
                            <li><a href="{{ action('ProfileController@show', $watcher['slug']) }}">{{ $watcher['name'] }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection