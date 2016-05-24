
<div class="form-group col-md-6">
    {!! Form::label('name', 'Name') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-md-6">
    {!! Form::label('email', 'E-Mail') !!}
    {!! Form::text('email', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-md-6">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
</div>