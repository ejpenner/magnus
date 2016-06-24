@foreach($opera as $opus)
    <div class="col-lg-{{ isset($columns) ? floor(12 / $columns) : 4 }} col-md-4 col-sm-6 col-xs-1">
        <div class="gallery-item">
            @if(Auth::check() and (Auth::user()->isOwner($opus) or Auth::user()->atLeastHasRole(config('roles.globalModerator'))))
                @include('partials._operations', ['model' => $opus, 'controller' => 'OpusController'])
            @endif
            <div class="vcenter">
                <div class="">
                    <a href="{{ action('OpusController@show', [$opus->id]) }}">
                        <img src="/{{ $opus->getThumbnail() }}" alt="{{ $opus->title }}">
                    </a>
                </div>
                <div class="item-details">
                    <h5><strong><a href="{{ action('OpusController@show', [$opus->id]) }}">{{ $opus->title }}</a></strong>
                        @if(!isset($showName) or $showName)
                            <br><a href="{{ action('ProfileController@show', $opus->user->slug) }}">{!! $opus->user->decorateUsername() !!}</a>
                        @endif
                    </h5>
                </div>
            </div>
        </div>
    </div>
@endforeach