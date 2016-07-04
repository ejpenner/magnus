<div class="col-lg-2 col-md-4">
    <div class="gallery-item">
        <div class="vcenter">
            <a href="{{ action('OpusController@show', [$opus->id]) }}">
                <img src="/{{ $opus->thumbnail_path }}" alt="{{ $opus->title }}">
            </a>
            <div class="item-details">
                <h5><strong><a href="{{ action('OpusController@show', [$opus->id]) }}">{{ $opus->title }}</a></strong>
                    @if(!isset($showName) or $showName)
                        <br><a href="{{ action('ProfileController@show', $opus->uslug) }}">{!! Magnus::username($opus->user_id) !!}</a>
                    @endif
                </h5>
            </div>
        </div>
        @if(Auth::check() and Magnus::isOwnerOrHasRole($opus, config('roles.gmod-code')))
            <div class="gallery-operations">
                @include('partials._operations', ['model' => $opus, 'controller' => 'OpusController'])
            </div>
        @endif
    </div>
</div>