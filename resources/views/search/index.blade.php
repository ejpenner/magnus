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

            <div ng-controller="ScrollController">
                <div class="container-fluid" infinite-scroll="scroller.nextPage()"
                     infinite-scroll-disabled="scroller.busy"
                     infinite-scroll-distance="1">
                    <div ng-repeat="opus in scroller.items track by $index">
                        <div ng-bind-html="opus | sanitize"></div>
                        <div class="spacer" style="clear: both;"></div>
                    </div>
                </div>
            </div>

        </div>
        {{--<div class="container">--}}
        {{--{{ $paginatedResults->render() }}--}}
        {{--</div>--}}
    @else
        <div class="container">
            <h4>No results found.</h4>
        </div>
    @endif
@endsection