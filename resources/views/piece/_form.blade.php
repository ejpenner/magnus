<div class="form-group">
    {!! Form::label('title', 'Submission Title') !!}
    {!! Form::text('title', null, ['class'=>'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('comments', 'Artist\'s Comments') !!}
    {!! Form::textarea('comments', null, ['class'=>'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::file('image', null, ['class'=>'form-control']) !!}
</div>
{!! Form::submit('Submit', ['class' => 'form-control']) !!}