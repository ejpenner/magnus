@extends('layouts.app')

@section('content')
    <div class="col-md-12">
        <div class="container-fluid">
            @include('partials._opusColumns', ['opera'=>$opera, 'columns'=>6])
        </div>
    </div>
    <div class="container">
        <span class="pull-left">{{ $opera->appends(['limit'=>($request->has('limit') ? $request->input('limit') : 18 )])->render() }}</span>
    </div>
@endsection