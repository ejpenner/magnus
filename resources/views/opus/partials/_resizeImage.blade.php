<div class="col-lg-4 col-lg-offset-4 panel panel-default">
    <div class="panel-body">
        {!! Form::label('resizeTo', 'Select preview size constraint') !!} <span class="optional-field">(default 680px)</span>
        {!! Form::select('resizeTo', [800 => '800px', 680 => '680px', 540 => '540px'],
                            680, ['class' => 'form-control']) !!}
    </div>
</div>