@extends('layouts.app')

@section('content')
    @if(count($results) > 0)
        <h4>Search results for: <small>{{ urldecode(substr(Request::path(), 7)) }}</small></h4>
    @endif
    <div class="clearfix">
        <div class="button-container">
            @include('search.partials._sortButtons')
        </div>
    </div>
    @if(count($results) > 0)
        <div ng-controller="ScrollController">
            <div class="container-fluid" infinite-scroll="scroller.nextPage()"
                 infinite-scroll-disabled="scroller.busy"
                 infinite-scroll-distance="0">
                <div ng-repeat="opusRows in scroller.items track by $index">
                    <div ng-repeat="opus in opusRows.row">
                        <div class="col-lg-2 col-md-4 col-sm-6 col-xs-1">
                            <div class="gallery-item">
                                <div class="vcenter">
                                    <div class="thumbnail-wrap">
                                        <a href="@{{ $rootScope.location.origin }}/opus/@{{ opus.slug }}">
                                            <div class="opus-image">
                                                <img class="opus-src" src="/@{{ opus.thumbnail_path }}" alt="@{{ opus.title }}">
                                            </div>
                                        </a>
                                    </div>
                                    <div class="item-details">
                                        <h5><strong><a href="@{{ $rootScope.location.origin }}/opus/@{{ opus.slug }}">@{{ opus.title }}</a></strong>
                                            <br><a href="@{{ $rootScope.location.origin }}/profile/@{{ opus.userslug }}">
                                                <span ng-bind-html="opus.username | username : opus.role_code | sanitize"></span>
                                            </a>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style='clear: both;'></div>
                </div>
            </div>
        </div>
    @else
        <div class="container">
            <h4>No results found.</h4>
        </div>
    @endif
@endsection