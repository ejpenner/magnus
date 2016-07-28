<div class="form-group">
    {!! Form::label('title', 'Title') !!}
    {!! Form::text('title', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('rawBody', 'Body') !!}
    {!! Form::textarea('rawBody', null, ['class' => 'form-control']) !!}
</div>

{!! Form::submit('Submit', ['class' => 'form-control btn btn-primary']) !!}