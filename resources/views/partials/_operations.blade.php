{!! Form::model($model, ['method'=>'delete', 'class'=>'delete-confirm operations',
		                               'action'=>[$controller.'@destroy', $model->id]]) !!}
<a href="{{ action($controller.'@edit', $model->id) }}" class="btn btn-cta-red">Edit</a>
{!! Form::submit('Delete', ['class' => 'btn']) !!}
{!! Form::close() !!}