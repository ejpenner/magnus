@if(Auth::user()->isWatched($user))
<a class="btn btn-danger" href="{{ action('UserController@unwatchUser', $user->slug) }}"><i class="fa fa-minus"></i> Unwatch User</a>
@else
<button type="button" class="btn btn-success" data-toggle="modal" data-target="#watchUserModal"><i class="fa fa-plus"></i> Watch User</button>

<div id="watchUserModal" class="modal fade" role="form">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Watch {{ $user->name }}?</h4>
            </div>

            <div class="modal-body">
                {!! Form::open(['action'=>['UserController@watchUser', $user->slug]]) !!}
                <div class="form-group">
                    <div class="checkbox-inline"><label>{!! Form::checkbox('watch_opus', 1) !!} Follow Opera</label></div>
                    <div class="checkbox-inline"><label>{!! Form::checkbox('create', 1) !!} Follow Comments</label></div>
                    <div class="checkbox-inline"><label>{!! Form::checkbox('edit', 1) !!} Follow Activity</label></div>
                </div>
                <div class="form-group">
                    {!! Form::submit('Watch!', ['class' => 'form-control btn btn-primary']) !!}
                </div>
                {!! Form::close() !!}
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
@endif