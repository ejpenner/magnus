<div class="text-center">
    <div class="piece-nav">
        <div class="btn-group">
            <a class="btn btn-default" href="{{ action('OpusController@show', [$galleryNav['previous']]) }}">Previous</a>
            <a class="btn btn-default" href="{{ action('OpusController@show', [$galleryNav['next']]) }}">Next</a>
        </div>
    </div>
</div>
@if($opus->galleries->count() > 0)
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                In Galleries
            </div>
            <div class="panel-body">
                <ul class="list-inline">
                    @foreach($opus->galleries as $gallery)
                        <li><a href="{{ action('GalleryController@show', $gallery->id) }}">{{ $gallery->name }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif

