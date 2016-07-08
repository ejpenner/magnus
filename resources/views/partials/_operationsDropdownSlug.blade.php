<div class="dropup">
    <button type="button" class="btn btn-xs btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Actions <span class="fa fa-wrench"></span>
    </button>
    <ul class="dropdown-menu">
        {!! Form::model($model, ['method'=>'delete', 'class'=>'delete-confirm operations',
                                       'action'=>[$controller.'@destroy', $model->slug]]) !!}
        <li><a class="btn btn-link" href="{{ action($controller.'@edit', [$model->slug]) }}">Edit</a></li>
        <li><button type="submit" class="btn btn-link"><i class="fa fa-trash"></i> Delete</button></li>
        <li><a class="btn btn-link" href="">Report</a></li>
        {!! Form::close() !!}
    </ul>
</div>
