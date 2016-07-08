<div class="col-md-3">
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
        <div class="gallery-operations">
            @if(Auth::check() and Magnus::isOwnerOrHasRole($opus, config('roles.moderator')))
                @include('partials._operationsDropdownSlug', ['model' => $opus, 'controller' => 'OpusController'])
            @endif
        </div>
    </div>
</div>