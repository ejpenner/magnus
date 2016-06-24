
<div class="row">
    <div class="col-md-3">
        <div style="margin: 0 auto; width:120px">
        <label for="">Current Avatar</label>
        <img class="avatar" src="{{ Auth::user()->getAvatar() }}" alt="">
        </div>
    </div>
    <div class="col-md-9">
        <div class="avatar-modal">
            <canvas id="avatar-cropper" style="width:600px; height:400px"></canvas>
            <form id="avatar-form" action="{{ action('UserController@uploadAvatar') }}">
                {!! csrf_field() !!}
                <div class="form-group form-inline">
                    <input type="file" name="avatar-src" id="avatar-file" class="form-control">
                    <button class="crop-submit btn btn-primary">Crop</button>
                </div>
            </form>
        </div>
    </div>
</div>
