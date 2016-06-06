@if(Session::has('message'))
    <div class="alert alert-dismissible fade in" role="alert">
        <i class="fa fa-lg fa-info"></i><button type="button" class="close btn btn-default" data-dismiss="alert" aria-hidden="true">&times;</button> {{ Session::get('message') }}</div>
@endif
@if(Session::has('success'))
    <div class="alert alert-success alert-dismissible fade in" role="alert">
        <i class="fa fa-lg fa-check"></i><button type="button" class="close btn btn-default" data-dismiss="alert" aria-hidden="true">&times;</button> {{ Session::get('success') }}</div>
@endif