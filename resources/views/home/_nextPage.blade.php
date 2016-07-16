@include('partials._opusColumns', ['opera'=>$opera, 'columns'=>6])
<a class="load-next" href="{{ $opera->nextPageUrl() }}">...</a>
