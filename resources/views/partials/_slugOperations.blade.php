{!! Form::model($model, ['method'=>'delete', 'class'=>'delete-confirm operations',
'action'=>[$controller.'@destroy', $model->slug]]) !!}
<a href="{{ action($controller.'@edit', [$model->slug]) }}"><button type="button" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i> Edit</button></a>
<button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Delete</button>
{!! Form::close() !!}