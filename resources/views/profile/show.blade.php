@extends('layouts.app')

@section('content')

    <div class="container">
        <h3>{{ $user->name }}</h3>
        <p>{{ $profile->biography }}</p>
        <hr>
        <div class="container gallery-container">
            @foreach($user->galleries as $gallery)
                <div class="col-md-3 gallery-item">
                    {{ $gallery->name }}
                    {{ $gallery->description }}
                    @if(Auth::check() and (Auth::user()->hasRole('admin') or Auth::user()->isOwner($gallery)))
                        <div class="container">@include('partials._operations', ['model' => $gallery, 'controller'=>'GalleryController'])</div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
    <div class="pull-left">

    </div>
@endsection