<div class="form-group">
    <input type="file" name="image" id="image" class="form-control">
</div>
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
    {!! Form::label('comment', 'Artist\'s Comments') !!} <span class="optional-field">optional</span>
    {!! Form::textarea('comment', null, ['class'=>'form-control', 'rows' => 6]) !!}
</div>
<div class="form-group">
    {!! Form::label('tags', 'Tags') !!} <span class="optional-field">optional, but recommended</span>
    {!! Form::text('tags', isset($tagString) ? $tagString : null, ['class'=>'form-control']) !!}
    <div class="optional-field">Be sure to separate tags with spaces!</div>
</div>
@if($galleries->count() > 0)
    <div class="panel panel-default">
        <div class="panel-heading">
            Add to galleries <span class="optional-field">(optional)</span>
        </div>
        <div class="panel-body">
            <div class="form-group gallery-select">
                @foreach($galleries as $i => $gallery)
                    <input type="checkbox" name="gallery_ids[]" id="{{$gallery->id}}"
                           @if(isset($opus) and $gallery->hasOpus($opus))
                                   checked
                           @endif
                           value="{{$gallery->id}}" class="checkbox-vis-hidden">
                    <label for="{{$gallery->id}}">{{ $gallery->name }}</label>
                @endforeach
            </div>
        </div>
    </div>
@endif
{!! Form::submit('Submit', ['class' => 'form-control']) !!}