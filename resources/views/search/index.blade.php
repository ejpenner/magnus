@extends('layouts.app')

@section('content')
    @if(count($paginatedResults) > 0)
        <h4>Search results for: <small>{{ urldecode(substr(Request::path(), 7)) }}</small></h4>
    @endif
    @include('search.partials._sortButtons')
    @if(count($paginatedResults) > 0)
        <div class="container-fluid">
            <div class="text-center">
                @foreach($paginatedResults as $result)
                    @include('search.partials._result', ['opus' => $result])
                @endforeach
            </div>
        </div>
        <div class="container">
            {{ $paginatedResults->appends(['sort'=>$sortUrl])->appends(['order'=>$orderUrl])->appends(['time'=>$periodUrl])->render() }}
        </div>
    @else
        <div class="container">
            <h4>No results found.</h4>
        </div>
    @endif
@endsection