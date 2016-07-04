@extends('layouts.app')

@section('content')
    @include('profile._header', ['user'=>$user, 'details'=>false])
    <div class="col-md-10 col-md-offset-1">
        <div class="container-fluid">
            @foreach($opera->chunk(4) as $operaChunk)
                <div class="row">
                    @foreach($operaChunk as $opus)
                        @include('partials._opus', ['opus' => $opus])
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
    <div class="container">
        <span class="pull-left">{{ $opera->render() }}</span>
    </div>
@endsection