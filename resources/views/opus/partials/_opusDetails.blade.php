<div class="panel panel-default">
    <div class="panel-body">
        <div class="piece-info">
            <div class="container-fluid">
                <div class="col-lg-9">
                        <a href="{{ action('ProfileController@show', $opus->user->slug) }}">
                            <img src="{{ $opus->user->getAvatar() }}" class="pull-left avatar" alt="avatar">
                        </a>
                        <h2>{{ $opus->title }}</h2>
                        <h4>by <a href="{{ action('ProfileController@show', $opus->user->slug) }}">{!! $opus->user->decorateUsername() !!}</a></h4>
                </div>
                <div class="col-lg-3">
                    <div class="pull-right">
                        @include('opus.partials._navigator', ['navigator' => $navigator])
                        @include('opus.partials._favoriteButton', ['opus' => $opus])
                    </div>
                </div>
            </div>
        </div>
        @unless($opus->tags->isEmpty())
            <ul class="list-inline">
                <strong>Tags</strong>
                @foreach($opus->tags as $tag)
                    <li><a href="{{ action('SearchController@searchAll', '@'.$tag->name) }}">{{ $tag->name }}</a></li>
                @endforeach
            </ul>
        @endunless
        @if($opus->galleries->count() > 0)
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">Featured in</h4>
                </div>
                <div class="panel-body">
                    <ul class="list-inline">
                        @foreach($opus->galleries as $gallery)
                            <li><a href="{{ action('GalleryController@show', $gallery->id) }}">{{ $gallery->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
    @endif
    <!-- Artist comments -->
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-body">
                    <p>{{ $opus->comment }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default details-panel">
                <div class="panel-heading">
                    <h4 class="panel-title">Details
                    @if(Auth::check() and Magnus::isOwnerOrHasRole($opus, config('roles.mod-code')))
                        <div class="pull-right operations">
                            {!! Form::model($opus, ['method'=>'delete', 'class'=>'delete-confirm operations',
                                                   'action'=>['OpusController@destroy', $opus->slug]]) !!}
                            <a class="btn btn-primary btn-xs" href="{{ action('OpusController@download', [$opus->slug]) }}">Download</a>
                            <a href="{{ action('OpusController@edit', [$opus->slug]) }}">
                                <button type="button" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i> Edit</button>
                            </a>
                            <button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Delete</button>
                            {!! Form::close() !!}

                        </div>

                    @else
                        <a class="btn btn-primary btn-xs pull-right" href="{{ action('OpusController@download', [$opus->slug]) }}">Download</a>
                    @endif
                    </h4>

                </div>
                <table class="table">
                    <tbody>
                    <tr>
                        <td>Views</td>
                        <td>{{ $opus->views }} <small>({{ $opus->daily_views  }} Today)</small></td>
                    </tr>
                    <tr>
                        <td>Favorites</td>
                        <td>{{ $favoriteCount }}
                            @if($favoriteCount > 0)
                                <span class="optional-field"><a href="{{ action('FavoriteController@show', $opus->slug) }}">(See who)</a></span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Submitted On</td>
                        <td>{{ $opus->created_at }}</td>
                    </tr>
                    <tr>
                        <td>Image Size</td>
                        <td>{{ $metadata['filesize'] }}</td>
                    </tr>
                    <tr>
                        <td>Resolution</td>
                        <td>{{ $metadata['resolution'] }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
