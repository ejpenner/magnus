@foreach($galleries->chunk(4) as $i => $gallery)
    <div class="row">
        @foreach($gallery as $j => $item)
            <div class="col-md-3 vcenter gallery-item">

                @if(isset($item->opera->first()->thumbnail_path))
                    <a href="{{ action('GalleryController@show', $item->id) }}">
                        <img src="/{{ $item->opera->first()->thumbnail_path }}" alt="">
                    </a>
                @endif

                <h4><a href="{{ action('GalleryController@show', $item->id) }}">{{ $item->name }}</a></h4>
                <p>{{ $item->description }}</p>

                @if(Auth::check() and (Auth::user()->atLeastHasRole(config('roles.globalModerator')) or Auth::user()->isOwner($item)))
                    <div class="clearfix">
                        @include('partials._galleryOperationsDropdown', ['id'=>$i.'-'.$j, 'gallery'=>$item])
                    </div>
                @endif
            </div>
        @endforeach
    </div>
@endforeach