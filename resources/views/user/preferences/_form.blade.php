<div class="form-group">
    <div class="form-inline">
        {!! Form::label('sex', 'Sex', ['class' => 'form-label']) !!}
        {!! Form::select('sex',
                        ['male'=>'Male', 'female'=>'Female', 'other'=>'Special Snowflake'],
                        null,
                        ['placeholder'=>'Pick your sex', 'class'=>'form-control']) !!}
        {!! Form::select('show_sex', [0=>'Don\'t Show', 1 => 'Show'], 1, ['class'=>'form-control']) !!}
    </div>
</div>

<div class="form-group">
    <div class="form-inline">
        {!! Form::label('dob','Date of Birth', ['class' => 'form-label']) !!}
        {!! Form::selectRange('dob_day',1,31, null, ['class' => 'form-control']) !!}
        {!! Form::selectMonth('dob_month' , null , ['class' => 'form-control']) !!}
        {!! Form::selectRange('dob_year',1940,2016, 2016, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    <div class="form-inline">
        {!! Form::label('Display Birthday') !!}
        {!! Form::select('show_dob',
                ['none'=>'Don\'t show my birthday publicly',
                 'half'=>'Show only the month and day publicly',
                 'full'=>'Show my full birthday and age publicly'],
                 'none',
                 ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-control">
    <div class="form-inline">
        {!! Form::label('per_page', 'Display') !!}
        {!! Form::select('per_page',[
                    18 => '18 Thumbnails per Page',
                    36 => '36 Thumbnails per Page',
                    56 => '56 Thumbnails per Page',],
                    18,
                    ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-control">
    <div class="form-inline">
        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    </div>
</div>