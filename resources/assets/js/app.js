$(document).ready(function() {

    $(".alert-success").slideDown(400);

    window.setTimeout(function() {
        $(".alert-success").fadeTo(500, 0).slideUp(500, function() {
            $(this).remove();
        });
    }, 3000);

    $('.delete-confirm').on('submit', function() {
        return confirm('Are you sure you want to delete this?');
    });

    $('#preview').click(function() {
        $('#fullview').show().unveil();
        $(this).toggle();
    });

    $('#fullview').click(function() {
        $(this).toggle();
        $('#preview').toggle();
    });


    $(window).scroll(function() {
        var x = $(this).scrollTop();
        $('#header-background').css('background-position', '100% ' + parseInt(-x) + 'px' + ', 0% ' + parseInt(-x) + 'px, center top');
    });

    var image = document.getElementById('avatar-cropper');

    function readURL(input) {

        if (input.files && input.files[0]) {
            console.log('Reading file');
            var reader = new FileReader();

            reader.readAsDataURL(input.files[0]);

            reader.onload = function(e) {
                avatarCropper.replace(e.target.result);
            };
        }
    }

    function readFile(input, imgElement) {

        if (input.files && input.files[0]) {
            console.log('Reading file');
            var reader = new FileReader();

            reader.readAsDataURL(input.files[0]);

            reader.onload = function(e) {
                $(imgElement).attr('src', e.target.result);
            };
        }
    }

    $(".reply-toggle").click(function() {
        $(this).children().show();
        $(this).children('.reply-btn').hide();
    });

    $('#avatar-file').change(function() {
        readURL(this);
    });

    $('#image').change(function() {
        readFile(this, '#preview');
        readFile(this, '#preview-edit');
        $('#preview').show();
        $('div.preview-container').show();
    });

    var avatarCropper = new Cropper(image, {
        aspectRatio: 1,
        crop: function(e) {
            console.log(e.detail.x);
            console.log(e.detail.y);
            console.log(e.detail.width);
            console.log(e.detail.height);
        }
    });

    $('.crop-submit').on('click', function(e) {
        console.log('Cropping avatar');
        var formObj = $('#avatar-form');
        var formURL = formObj.attr("action");
        var token = $('input[name=_token]');

        console.log(formURL);
        avatarCropper.getCroppedCanvas().toBlob(function(blob) {
            var formData = new FormData();


            formData.append('image', blob);
            console.log(formData);

            // Use `jQuery.ajax` method
            $.ajax({
                url: formURL,
                method: "POST",
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': token.val()
                },
                processData: false,
                contentType: false,
                success: function() {
                    console.log('Upload success');
                },
                error: function() {
                    console.log('Upload error');
                }
            });

        });
        e.preventDefault();
        window.setTimeout(function() {
            location.reload();
        }, 2000)
    });
});