@foreach($favorites as $favorite)
    <div class="col-lg-{{ isset($columns) ? floor(12 / $columns) : 3 }} col-md-3 col-sm-4 col-xs-12">
        <div class="gallery-item">
            <div class="vcenter">
                @include('partials._opusThumbnail', ['opus'=>$favorite->opus, 'action'=>'OpusController@show', 'params'=>[$favorite->opus->slug]])
                <h5>
                    <strong><a href="{{ action('OpusController@show', [$favorite->opus->slug]) }}">{{ $favorite->opus->title }}</a></strong>
                    <br>
                    <a href="{{ action('ProfileController@show', $favorite->opus->user->slug) }}">{!! $favorite->opus->user->decorateUsername() !!}</a>
                </h5>
            </div>
        </div>
    </div>
@endforeach