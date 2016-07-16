@extends('layouts.app')

@section('content')
    <div class="col-md-12">
        @include('home.partials._sortButtons', [$filterSegment])
        <div class="container-fluid" id="infinite">

            @include('partials._opusColumns', ['opera'=>$opera, 'columns'=>6])
                {{--<span class="pull-left">{{ $opera->appends(['limit'=>($request->has('limit') ? $request->input('limit') : null )])->render() }}</span>--}}

            <a class="load-next" href="{{ action('HomeController@nextPage') }}">test</a>
        </div>

    </div>

@endsection