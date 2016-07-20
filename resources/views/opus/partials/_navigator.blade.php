@if($navigator != null and isset($gallery))
    <div class="text-center">
        <div class="piece-nav">
            <div class="btn-group">
                <a class="btn btn-default btn-lg" href="{{ action('OpusController@galleryShow', [$gallery->id, $navigator['previous']]) }}">Previous</a>
                <a class="btn btn-default btn-lg" href="{{ action('OpusController@galleryShow', [$gallery->id, $navigator['next']]) }}">Next</a>
            </div>
        </div>
    </div>
@else
    <div class="text-center">
        <div class="piece-nav">
            <div class="row">
            <div class="btn-group">
                <a class="btn btn-default btn-lg" href="{{ action('OpusController@show', [$navigator['previous']]) }}">Previous</a>
                <a class="btn btn-default btn-lg" href="{{ action('OpusController@show', [$navigator['next']]) }}">Next</a>
            </div>
            </div>
        </div>
    </div>
@endif

