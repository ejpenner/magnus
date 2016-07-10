<div class="container">
    <div class="row">
        <div class="col-md-2">
            <p>{{ $user->name }}'s current avatar</p>
            <img src="{{ $user->getAvatar() }}" alt="avatar">
        </div>
        <div class="col-md-8">
            <form id="avatar-form" action="{{ action('AccountController@uploadAvatarAdmin', $user->slug) }}">
                {!! csrf_field() !!}
                <canvas id="avatar-cropper" width="600" height="400"></canvas>
                <div class="form-group form-inline">
                    <input type="file" name="avatar-src" id="avatar-file" class="form-control">
                    <button class="crop-submit btn btn-primary">Crop</button>
                </div>
            </form>
        </div>
    </div>
</div>