<div class="search-sort-buttons">
    <div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            @if(Request::is('trending*')
                or Request::is('popular*')
                or Request::is('newest*'))
                Sorted by {{ Request::segment(1) }} <i class="caret"></i>
            @else
                Sort By <span class="caret"></span>
            @endif
        </button>
        <ul class="dropdown-menu">
            <li><a href="{{ action('HomeController@recent', ['trending', Request::segment(2)]) }}">Trending</a></li>
            <li><a href="{{ action('HomeController@recent', ['popular', Request::segment(2)])}}">Popular</a></li>
            <li><a href="{{ action('HomeController@recent', ['newest', Request::segment(2)]) }}">Newest</a></li>
        </ul>
    </div>
    <div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            @if(Request::is('*/month*') or  Request::is('*/week*') or Request::is('*/72h*') or Request::is('*/48h')
                 or Request::is('*/24h*') or Request::is('*/8h*'))
                Submitted in the last {{ Request::segment(2) }} <span class="caret"></span>
            @else
                Filter submission date <span class="caret"></span>
            @endif
        </button>
        <ul class="dropdown-menu">
            <li><a href="{{ action('HomeController@recent', [$filterSegment, 'month']) }}">In the last month</a></li>
            <li><a href="{{ action('HomeController@recent', [$filterSegment, 'week']) }}">In the last week</a></li>
            <li><a href="{{ action('HomeController@recent', [$filterSegment, '72h']) }}">In the last three days</a></li>
            <li><a href="{{ action('HomeController@recent', [$filterSegment, '48h']) }}">In the last two days</a></li>
            <li><a href="{{ action('HomeController@recent', [$filterSegment, '24h']) }}">In the last 24 hours</a></li>
            <li><a href="{{ action('HomeController@recent', [$filterSegment, '8h']) }}">In the last 8 hours</a></li>
        </ul>
    </div>
    @if(Request::segment(2) != null and Request::segment(1) != null)
        <a href="{{ action('HomeController@recent', [$filterSegment, null]) }}" class="btn btn-primary">Reset Filter</a>
    @endif
</div>