{!! Form::label('category_name', 'Category Name') !!}

{!! Form::text('category_name', ['class' => 'form-control', 'id' => 'category_name']) !!}

{!! Form::label('category_description', 'Category Name') !!}

{!! Form::textarea('category_description', ['class' => 'form-control']) !!}

{!! Form::select('parent_category_id', $categories, null, ['placeholder' => 'Pick a parent category (optional)', 'class' => 'form-control']) !!}

{!! Form::submit('Save Category', ['class' => 'btn btn-primary']) !!}