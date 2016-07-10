<div class="container">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="piece-info">
                <div class="container-fluid">
                    <div class="col-md-9">
                        <a href="{{ action('ProfileController@show', $opus->user->slug) }}">
                            <img src="{{ $opus->user->getAvatar() }}" class="pull-left avatar" alt="avatar">
                        </a>
                        <h3>{{ $opus->title }}</h3>
                        <p>By <a href="{{ action('ProfileController@show', $opus->user->slug) }}">{{ $opus->user->name }}</a></p>
                    </div>
                </div>
            </div>
            <div class="row">
                @unless($opus->tags->isEmpty())
                    <div class="container-fluid">
                        <ul class="list-inline">
                            <strong>Tags</strong>
                            @foreach($opus->tags as $tag)
                                <li><a href="{{ action('SearchController@searchAll', '@'.$tag->name) }}">{{ $tag->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                @endunless
            </div>
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
                        Details
                        @if(Auth::check() and Magnus::isOwnerOrHasRole($opus, config('roles.moderator')))
                            <div class="pull-right operations">
                                {!! Form::model($opus, ['method'=>'delete', 'class'=>'delete-confirm operations',
                                                       'action'=>['OpusController@destroy', $opus->slug]]) !!}
                                <a href="{{ action('OpusController@edit', [$opus->slug]) }}">
                                    <button type="button" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i> Edit</button>
                                </a>
                                <button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Delete</button>
                                <a class="btn btn-primary btn-xs" href="{{ action('OpusController@download', [$opus->slug]) }}">Download</a>
                                {!! Form::close() !!}
                            </div>
                        @endif
                    </div>
                    <table class="table">
                        <tbody>
                        <tr>
                            <td>Views</td>
                            <td>{{ $opus->views }} <small>({{ $opus->daily_views  }} Today)</small></td>
                        </tr>
                        <tr>
                            <td>Submitted On</td>
                            <td>{{ $opus->published_at }}</td>
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
</div>