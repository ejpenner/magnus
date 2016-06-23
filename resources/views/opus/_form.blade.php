<div class="form-group">
    {!! Form::label('title', 'Submission Title') !!}
    {!! Form::text('title', null, ['class'=>'form-control']) !!}
    @if ($errors->has('title'))
        <span class="help-block">
            <strong>{{ $errors->first('title') }}</strong>
        </span>
    @endif
</div>
<div class="form-group">
    {!! Form::label('comment', 'Artist\'s Comments') !!}
    {!! Form::textarea('comment', null, ['class'=>'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('tags', 'Tags') !!}
    {!! Form::text('tags', null, ['class'=>'form-control']) !!}
    <p class="alert alert-info">Be sure to separate tags with spaces</p>
</div>
<div class="form-group">
    <input type="file" name="image" id="image" class="form-control">
</div>
{!! Form::submit('Submit', ['class' => 'form-control']) !!}