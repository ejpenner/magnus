<div class="control-group col-md-6">
    {!! Form::label('name', 'Name') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<div class="control-group col-md-6">
    {!! Form::label('email', 'E-Mail') !!}
    {!! Form::text('email', null, ['class' => 'form-control']) !!}
</div>

<div class="control-group col-md-6">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
</div>
