{{--@include('partials._modal', ['modalName'=>'tester','buttonText'=>'New Modal','title'=>'Test', 'body'=>"<i>TEST</i>"])--}}
<button type="button" class="btn btn-success" data-toggle="modal" data-target="#{{ $modalName }}">{{ $buttonText }}</button>
<div id="{{ $modalName }}" class="modal fade" role="form">
    <div class="modal-dialog">

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{ $title }}</h4>
            </div>

            <div class="modal-body">
                {!! $body !!}
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
