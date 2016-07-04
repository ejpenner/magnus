<div class="flash-messages">
    @if (count($errors))
        <div class="alert alert-danger alert-dismissible fade in" role="alert">
            <button type="button" class="close btn btn-default" data-dismiss="alert" aria-hidden="true">&times;</button>
            <ul>
            @foreach($errors->all() as $error)
                <li><i class="fa fa-lg fa-ban"></i> {{ $error }}</li>
            @endforeach
            </ul>
        </div>
    @endif
</div>