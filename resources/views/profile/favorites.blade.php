@extends('layouts.app')
@section('content')
    @include('profile._header', ['profile'=>$profile,'user'=>$user,'details'=>false])
    @foreach($favorites as $favorite)
        <div class="col-lg-2 col-md-4 col-sm-6 col-xs-1">
            <div class="gallery-item">
                <div class="vcenter">
                    @include('partials._opusThumbnail', ['opus'=>$favorite->opus, 'action'=>'OpusController@show', 'params'=>[$favorite->opus->slug]])
                    <div class="item-details">
                        <h5><strong><a href="{{ action('OpusController@show', [$favorite->opus->slug]) }}">{{ $favorite->opus->title }}</a></strong>
                            @if(!isset($showName) or $showName)
                                <br><a href="{{ action('ProfileController@show', $favorite->opus->user->slug) }}">{!! $favorite->opus->user->decorateUsername() !!}</a>
                            @endif
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection