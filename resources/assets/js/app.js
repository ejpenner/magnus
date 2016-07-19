$(document).ready(function() {

    window.setTimeout(function() {
        $('.alert-success').fadeTo(500, 0).slideUp(500, function() {
            $(this).remove();
        });
    }, 3000);

    $('.delete-confirm').on('submit', function() {
        return confirm('Are you sure you want to delete this?');
    });

    // $(".opus-src").unveil();

    $('#preview').click(function() {
        $('.fullview-box').show();
        $(this).toggle();
        $('#fullview').show().unveil();
    });

    $('#fullview').click(function() {
        $(this).toggle();
        $('.fullview-box').toggle();
        $('#preview').toggle();
    });

    $('#selectAllOpus').click(function() {
        var checkbox = $('.opus-message-select');
        checkbox.prop('checked', !checkbox.is(":checked"));
    });


    //var num = 150; //number of pixels before modifying styles
    var navpos = $('.top-header').offset();
    var sortButton = $('.button-container');
    var sortButtonPos = sortButton.offset();

    $(window).bind('scroll', function() {

        var x = $(this).scrollTop();
        $('#header-background').css('background-position', '100% ' + parseInt(-x) + 'px' + ', 0% ' + parseInt(-x) + 'px, center top');

        if ($(window).scrollTop() > navpos.top) {
            $('.top-header').addClass('fixed');
        } else {
            $('.top-header').removeClass('fixed');
        }
        try {
            if ($(window).scrollTop() > sortButtonPos.top - parseInt(2 * sortButton.height())) {
                $('.button-container').addClass('fixed-buttons');
            } else {
                $('.button-container').removeClass('fixed-buttons');
            }
        } catch (e) {}
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

    var $replyToggle = $('.reply-toggle');

    $replyToggle.click(function() {
        $(this).children().show();
        $(this).children('.reply-btn').hide();
    });


    var anchor = window.location.hash;
    if (anchor == '#replyTop') {
        $(anchor).children('.reply-form').show();
        $(anchor).children('.reply-btn').hide();
    }


    $('#avatar-file').change(function() {
        readURL(this);
    });

    // $('.opus-overlay').on('hover', function() {
    //     console.log('overlay trigger');
    //     $(this).fadeIn(300);
    // }, function() {
    //     $(this).fadeOut(300);
    // });

    $('#image').change(function() {
        readFile(this, '#preview-upload');
        readFile(this, '#preview-edit');
        $('#preview-upload').show();
        $('div.preview-container').show();
    });

    try {
        var avatarCropper = new Cropper(image, {
            aspectRatio: 1,
            crop: function(e) {
                // console.log(e.detail.x);
                // console.log(e.detail.y);
                // console.log(e.detail.width);
                // console.log(e.detail.height);
            }
        });
    } catch (e) {}

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