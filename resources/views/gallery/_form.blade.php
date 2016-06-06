<div class="form-group">
    {!! Form::label('name', 'Gallery Name') !!}
    {!! Form::text('name', null, ['class'=>'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('description', 'Gallery Description') !!}
    {!! Form::textarea('description', null, ['class'=>'form-control']) !!}
</div>

{!! Form::submit('Submit', ['class' => 'form-control']) !!}