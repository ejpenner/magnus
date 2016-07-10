@foreach($opera as $opus)
    <div class="col-lg-{{ isset($columns) ? floor(12 / $columns) : 2 }} col-md-4 col-sm-6 col-xs-1">
        <div class="gallery-item">
            <div class="vcenter">
                @include('partials._opusThumbnail', ['opus'=>$opus, 'action'=>'OpusController@show', 'params'=>[$opus->slug]])
                <div class="item-details">
                    <h5><strong><a href="{{ action('OpusController@show', [$opus->slug]) }}">{{ $opus->title }}</a></strong>
                        @if(!isset($showName) or $showName)
                            <br><a href="{{ action('ProfileController@show', $opus->user->slug) }}">{!! $opus->user->decorateUsername() !!}</a>
                        @endif
                    </h5>
                </div>
            </div>
        </div>
    </div>
@endforeach