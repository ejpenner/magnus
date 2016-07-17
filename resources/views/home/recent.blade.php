

@extends('layouts.app')

@section('content')
    <div class="col-md-12">
        @include('home.partials._sortButtons', [$filterSegment])
    </div>
    <div ng-controller="ScrollController">
        <div class="container-fluid" infinite-scroll='scroller.nextPage()' infinite-scroll-disabled='scroller.busy' infinite-scroll-distance='0'>
            @include('partials._opusColumns', ['opera'=>$opera, 'columns'=>6])
            <div ng-repeat="opus in scroller.items track by $index">
                {{--@{{ opus }}--}}
                <div ng-bind-html="opus | sanitize"></div>
            </div>
        </div>
    </div>
@endsection
