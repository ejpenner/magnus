@foreach($galleries->chunk(4) as $i => $gallery)
    <div class="row">
        @foreach($gallery as $j => $item)
            <div class="col-md-3">
                <div class="gallery-item">
                    <div class="vcenter">
                        @if(isset($item->opera->first()->thumbnail_path))
                            <a href="{{ action('GalleryController@show', $item->id) }}">
                                <img src="/{{ $item->opera->first()->thumbnail_path }}" alt="">
                            </a>
                        @endif
                        <h5><a href="{{ action('GalleryController@show', $item->id) }}">{{ $item->name }}</a></h5>
                    </div>
                </div>
                <div class="gallery-operations">
                    @if(Auth::check() and (Auth::user()->atLeastHasRole(config('roles.globalModerator')) or Auth::user()->isOwner($item)))
                        <div>
                            @include('partials._galleryOperationsDropdown', ['id'=>$i.'-'.$j, 'gallery'=>$item])
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@endforeach