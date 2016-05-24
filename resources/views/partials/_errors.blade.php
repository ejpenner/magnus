@if (count($errors))
        @foreach($errors->all() as $error)
            <div class="alert alert-danger alert-dismissible fade in" role="alert"><i class="fa fa-lg fa-ban"></i>
                <button type="button" class="close btn btn-default" data-dismiss="alert" aria-hidden="true">&times;</button> {{ $error }}</div>
        @endforeach
@endif