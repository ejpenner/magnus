<div class="form-group">
    {!! Form::label('name', 'Gallery Name') !!}
    {!! Form::text('name') !!}
</div>

<div class="form-group">
    {!! Form::label('description', 'Gallery Description') !!}
    {!! Form::text('description') !!}
</div>

{!! Form::submit('Submit', ['class' => 'form-control']) !!}