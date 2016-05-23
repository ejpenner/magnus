{!! Form::model($model, ['method'=>'delete', 'class'=>'delete-confirm operations',
		                               'action'=>[$controller.'@destroy', $model->id]]) !!}
<a href="{{ action($controller.'@edit', [$model->id]) }}"><button type="button" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i> Edit</button></a>
<button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Delete</button>
{!! Form::close() !!}