@extends('layouts.app')

@section('content')
    @if(count($paginatedResults) > 0)
        <div class="container-fluid">
            <h4>Search results for: <small>{{ urldecode(substr(Request::path(), 7)) }}</small></h4>
            <div class="text-center">
                @foreach($paginatedResults as $result)
                    @include('search.partials._result', ['opus' => $result])
                @endforeach
            </div>
        </div>
        <div class="container">
            {{ $paginatedResults->render() }}
        </div>
    @else
        <div class="container">
            <p>No results found.</p>
        </div>
    @endif
@endsection