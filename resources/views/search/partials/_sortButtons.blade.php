<div class="search-sort-buttons">
    <div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            @if(Request::has('sort') and (Request::input('sort') == 'relevance'
                or Request::input('sort') == 'hot'
                or Request::input('sort') == 'popular'
                or Request::input('sort') == 'date'))
                Sorted by {{ Request::input('sort') }} <i class="caret"></i>
            @else
                Sort By <span class="caret"></span>
            @endif
        </button>
        <ul class="dropdown-menu">
            <li><a href="{{ Request::fullUrlWithQuery(['sort'=>'relevance']) }}">Relevance</a></li>
            <li><a href="{{ Request::fullUrlWithQuery(['sort'=>'hot']) }}">Hot</a></li>
            <li><a href="{{ Request::fullUrlWithQuery(['sort'=>'popular']) }}">Popular</a></li>
            <li><a href="{{ Request::fullUrlWithQuery(['sort'=>'date']) }}">Date</a></li>
        </ul>
    </div>
    <div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            @if(Request::has('sort') and (strtolower(Request::input('order')) == 'asc'
                                       or strtolower(Request::input('order')) == 'desc'))
                Ordered {{ ucwords(Request::input('order')) }} <span class="caret"></span>
            @else
                Order By <span class="caret"></span>
            @endif
        </button>
        <ul class="dropdown-menu">
            <li><a href="{{ Request::fullUrlWithQuery(['order'=>'desc']) }}">Descending</a></li>
            <li><a href="{{ Request::fullUrlWithQuery(['order'=>'asc']) }}">Ascending</a></li>
        </ul>
    </div>
    <div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            @if(Request::has('sort') and (strtolower(Request::input('time')) == 'month'
                                       or strtolower(Request::input('time')) == 'week'
                                       or strtolower(Request::input('time')) == '72h'
                                       or strtolower(Request::input('time')) == '48h'
                                       or strtolower(Request::input('time')) == '24h'
                                       or strtolower(Request::input('time')) == '8h'))
                Submitted in the last {{ Request::input('time') }} <span class="caret"></span>
            @else
                Filter submission date <span class="caret"></span>
            @endif
        </button>
        <ul class="dropdown-menu">
            <li><a href="{{ Request::fullUrlWithQuery(['time'=>'month']) }}">In the last month</a></li>
            <li><a href="{{ Request::fullUrlWithQuery(['time'=>'week']) }}">In the last week</a></li>
            <li><a href="{{ Request::fullUrlWithQuery(['time'=>'72h']) }}">In the last three days</a></li>
            <li><a href="{{ Request::fullUrlWithQuery(['time'=>'48h']) }}">In the last two days</a></li>
            <li><a href="{{ Request::fullUrlWithQuery(['time'=>'24h']) }}">In the last 24 hours</a></li>
            <li><a href="{{ Request::fullUrlWithQuery(['time'=>'8h']) }}">In the last 8 hours</a></li>
        </ul>
    </div>
    @if(Request::has('time') and Request::input('time') != 'null')
        <a href="{{ Request::fullUrlWithQuery(['time'=>'null']) }}" class="btn btn-primary">Reset Filter</a>
    @endif
</div>