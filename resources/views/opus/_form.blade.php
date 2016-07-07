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
    {!! Form::label('comment', 'Artist\'s Comments') !!}
    {!! Form::textarea('comment', null, ['class'=>'form-control', 'rows' => 6]) !!}
</div>
<div class="form-group">
    {!! Form::label('tags', 'Tags') !!}
    {!! Form::text('tags', isset($tagString) ? $tagString : null, ['class'=>'form-control']) !!}
    <div class="alert alert-info">Be sure to separate tags with spaces</div>
</div>
@if($galleries->count() > 0)
    <div class="panel panel-default">
        <div class="panel-heading">
            Select Galleries
        </div>
        <div class="panel-body">
            <div class="form-group gallery-select">
                @foreach($galleries as $i => $gallery)
                    <input type="checkbox" name="gallery_ids[]" id="gallery_id{{$i}}" value="{{$gallery->id}}" class="checkbox-vis-hidden">
                    <label for="gallery_id{{$i}}">{{ $gallery->name }}</label>
                @endforeach
            </div>
        </div>
    </div>
@endif
{!! Form::submit('Submit', ['class' => 'form-control']) !!}