(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
"use strict";

$(document).ready(function () {

    $(".alert-success").slideDown(400);

    window.setTimeout(function () {
        $(".alert-success").fadeTo(500, 0).slideUp(500, function () {
            $(this).remove();
        });
    }, 3000);

    $('.delete-confirm').on('submit', function () {
        return confirm('Are you sure you want to delete this?');
    });

    $('#preview').click(function () {
        console.log('hey clicked me');
        // $('#fullview').trigger("unveil").show();
        // $(this).hide();
    });

    $('#fullview').click(function () {
        // $(this).hide();
        // $('#preview').show();
    });

    $(window).scroll(function () {
        var x = $(this).scrollTop();
        $('#header-background').css('background-position', '100% ' + parseInt(-x) + 'px' + ', 0% ' + parseInt(-x) + 'px, center top');
    });

    var image = document.getElementById('avatar-cropper');

    function readURL(input) {

        if (input.files && input.files[0]) {
            console.log('Reading file');
            var reader = new FileReader();

            reader.readAsDataURL(input.files[0]);

            reader.onload = function (e) {
                avatarCropper.replace(e.target.result);
            };
        }
    }

    function readFile(input, imgElement) {

        if (input.files && input.files[0]) {
            console.log('Reading file');
            var reader = new FileReader();

            reader.readAsDataURL(input.files[0]);

            reader.onload = function (e) {
                $(imgElement).attr('src', e.target.result);
            };
        }
    }

    $(".reply-toggle").click(function () {
        $(this).children().show();
        $(this).children('.reply-btn').hide();
    });

    $('#avatar-file').change(function () {
        readURL(this);
    });

    $('#image').change(function () {
        readFile(this, '#preview');
        readFile(this, '#preview-edit');
        $('#preview').show();
        $('div.preview-container').show();
    });

    var avatarCropper = new Cropper(image, {
        aspectRatio: 1,
        crop: function (e) {
            console.log(e.detail.x);
            console.log(e.detail.y);
            console.log(e.detail.width);
            console.log(e.detail.height);
        }
    });

    $('.crop-submit').on('click', function (e) {
        console.log('Cropping avatar');
        var formObj = $('#avatar-form');
        var formURL = formObj.attr("action");
        var token = $('input[name=_token]');

        console.log(formURL);
        avatarCropper.getCroppedCanvas().toBlob(function (blob) {
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
                success: function () {
                    console.log('Upload success');
                },
                error: function () {
                    console.log('Upload error');
                }
            });
        });
        e.preventDefault();
        window.setTimeout(function () {
            location.reload();
        }, 2000);
    });
});

},{}]},{},[1])
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIi4uLy4uLy5ucG0tbG9jYWwvZ2FsbGVyeS1hcHAvbm9kZV9tb2R1bGVzL2Jyb3dzZXItcGFjay9fcHJlbHVkZS5qcyIsInJlc291cmNlcy9hc3NldHMvanMvYXBwLmpzIl0sIm5hbWVzIjpbXSwibWFwcGluZ3MiOiJBQUFBO0FDQUE7O0FBQ0EsRUFBRSxRQUFGLEVBQVksS0FBWixDQUFrQixZQUFXOztBQUV6QixNQUFFLGdCQUFGLEVBQW9CLFNBQXBCLENBQThCLEdBQTlCOztBQUVBLFdBQU8sVUFBUCxDQUFrQixZQUFXO0FBQ3pCLFVBQUUsZ0JBQUYsRUFBb0IsTUFBcEIsQ0FBMkIsR0FBM0IsRUFBZ0MsQ0FBaEMsRUFBbUMsT0FBbkMsQ0FBMkMsR0FBM0MsRUFBZ0QsWUFBVztBQUN2RCxjQUFFLElBQUYsRUFBUSxNQUFSO0FBQ0gsU0FGRDtBQUdILEtBSkQsRUFJRyxJQUpIOztBQU1BLE1BQUUsaUJBQUYsRUFBcUIsRUFBckIsQ0FBd0IsUUFBeEIsRUFBa0MsWUFBVztBQUN6QyxlQUFPLFFBQVEsdUNBQVIsQ0FBUDtBQUNILEtBRkQ7O0FBSUEsTUFBRSxVQUFGLEVBQWMsS0FBZCxDQUFvQixZQUFXO0FBQzNCLGdCQUFRLEdBQVIsQ0FBWSxnQkFBWjs7O0FBR0gsS0FKRDs7QUFNQSxNQUFFLFdBQUYsRUFBZSxLQUFmLENBQXFCLFlBQVc7OztBQUcvQixLQUhEOztBQUtBLE1BQUUsTUFBRixFQUFVLE1BQVYsQ0FBaUIsWUFBVztBQUN4QixZQUFJLElBQUksRUFBRSxJQUFGLEVBQVEsU0FBUixFQUFSO0FBQ0EsVUFBRSxvQkFBRixFQUF3QixHQUF4QixDQUE0QixxQkFBNUIsRUFBbUQsVUFBVSxTQUFTLENBQUMsQ0FBVixDQUFWLEdBQXlCLElBQXpCLEdBQWdDLE9BQWhDLEdBQTBDLFNBQVMsQ0FBQyxDQUFWLENBQTFDLEdBQXlELGdCQUE1RztBQUNILEtBSEQ7O0FBS0EsUUFBSSxRQUFRLFNBQVMsY0FBVCxDQUF3QixnQkFBeEIsQ0FBWjs7QUFFQSxhQUFT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USxHQUFSLENBQVksZ0JBQVo7QUFDSCxpQkFYRTtBQVlILHVCQUFPLFlBQVc7QUFDZCw0QkFBUSxHQUFSLENBQVksY0FBWjtBQUNIO0FBZEUsYUFBUDtBQWlCSCxTQXpCRDtBQTBCQSxVQUFFLGNBQUY7QUFDQSxlQUFPLFVBQVAsQ0FBa0IsWUFBVztBQUN6QixxQkFBUyxNQUFUO0FBQ0gsU0FGRCxFQUVHLElBRkg7QUFHSCxLQXJDRDtBQXNDSCxDQTVIRCIsImZpbGUiOiJnZW5lcmF0ZWQuanMiLCJzb3VyY2VSb290IjoiIiwic291cmNlc0NvbnRlbnQiOlsiKGZ1bmN0aW9uIGUodCxuLHIpe2Z1bmN0aW9uIHMobyx1KXtpZighbltvXSl7aWYoIXRbb10pe3ZhciBhPXR5cGVvZiByZXF1aXJlPT1cImZ1bmN0aW9uXCImJnJlcXVpcmU7aWYoIXUmJmEpcmV0dXJuIGEobywhMCk7aWYoaSlyZXR1cm4gaShvLCEwKTt2YXIgZj1uZXcgRXJyb3IoXCJDYW5ub3QgZmluZCBtb2R1bGUgJ1wiK28rXCInXCIpO3Rocm93IGYuY29kZT1cIk1PRFVMRV9OT1RfRk9VTkRcIixmfXZhciBsPW5bb109e2V4cG9ydHM6e319O3Rbb11bMF0uY2FsbChsLmV4cG9ydHMsZnVuY3Rpb24oZSl7dmFyIG49dFtvXVsxXVtlXTtyZXR1cm4gcyhuP246ZSl9LGwsbC5leHBvcnRzLGUsdCxuLHIpfXJldHVybiBuW29dLmV4cG9ydHN9dmFyIGk9dHlwZW9mIHJlcXVpcmU9PVwiZnVuY3Rpb25cIiYmcmVxdWlyZTtmb3IodmFyIG89MDtvPHIubGVuZ3RoO28rKylzKHJbb10pO3JldHVybiBzfSkiLCJcInVzZSBzdHJpY3RcIjtcbiQoZG9jdW1lbnQpLnJlYWR5KGZ1bmN0aW9uKCkge1xuXG4gICAgJChcIi5hbGVydC1zdWNjZXNzXCIpLnNsaWRlRG93big0MDApO1xuXG4gICAgd2luZG93LnNldFRpbWVvdXQoZnVuY3Rpb24oKSB7XG4gICAgICAgICQoXCIuYWxlcnQtc3VjY2Vzc1wiKS5mYWRlVG8oNTAwLCAwKS5zbGlkZVVwKDUwMCwgZnVuY3Rpb24oKSB7XG4gICAgICAgICAgICAkKHRoaXMpLnJlbW92ZSgpO1xuICAgICAgICB9KTtcbiAgICB9LCAzMDAwKTtcblxuICAgICQoJy5kZWxldGUtY29uZmlybScpLm9uKCdzdWJtaXQnLCBmdW5jdGlvbigpIHtcbiAgICAgICAgcmV0dXJuIGNvbmZpcm0oJ0FyZSB5b3Ugc3VyZSB5b3Ugd2FudCB0byBkZWxldGUgdGhpcz8nKTtcbiAgICB9KTtcblxuICAgICQoJyNwcmV2aWV3JykuY2xpY2soZnVuY3Rpb24oKSB7XG4gICAgICAgIGNvbnNvbGUubG9nKCdoZXkgY2xpY2tlZCBtZScpO1xuICAgICAgICAvLyAkKCcjZnVsbHZpZXcnKS50cmlnZ2VyKFwidW52ZWlsXCIpLnNob3coKTtcbiAgICAgICAgLy8gJCh0aGlzKS5oaWRlKCk7XG4gICAgfSk7XG5cbiAgICAkKCcjZnVsbHZpZXcnKS5jbGljayhmdW5jdGlvbigpIHtcbiAgICAgICAgLy8gJCh0aGlzKS5oaWRlKCk7XG4gICAgICAgIC8vICQoJyNwcmV2aWV3Jykuc2hvdygpO1xuICAgIH0pO1xuXG4gICAgJCh3aW5kb3cpLnNjcm9sbChmdW5jdGlvbigpIHtcbiAgICAgICAgdmFyIHggPSAkKHRoaXMpLnNjcm9sbFRvcCgpO1xuICAgICAgICAkKCcjaGVhZGVyLWJhY2tncm91bmQnKS5jc3MoJ2JhY2tncm91bmQtcG9zaXRpb24nLCAnMTAwJSAnICsgcGFyc2VJbnQoLXgpICsgJ3B4JyArICcsIDAlICcgKyBwYXJzZUludCgteCkgKyAncHgsIGNlbnRlciB0b3AnKTtcbiAgICB9KTtcblxuICAgIHZhciBpbWFnZSA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdhdmF0YXItY3JvcHBlcicpO1xuXG4gICAgZnVuY3Rpb24gcmVhZFVSTChpbnB1dCkge1xuXG4gICAgICAgIGlmIChpbnB1dC5maWxlcyAmJiBpbnB1dC5maWxlc1swXSkge1xuICAgICAgICAgICAgY29uc29sZS5sb2coJ1JlYWRpbmcgZmlsZScpO1xuICAgICAgICAgICAgdmFyIHJlYWRlciA9IG5ldyBGaWxlUmVhZGVyKCk7XG5cbiAgICAgICAgICAgIHJlYWRlci5yZWFkQXNEYXRhVVJMKGlucHV0LmZpbGVzWzBdKTtcblxuICAgICAgICAgICAgcmVhZGVyLm9ubG9hZCA9IGZ1bmN0aW9uKGUpIHtcbiAgICAgICAgICAgICAgICBhdmF0YXJDcm9wcGVyLnJlcGxhY2UoZS50YXJnZXQucmVzdWx0KTtcbiAgICAgICAgICAgIH07XG4gICAgICAgIH1cbiAgICB9XG5cbiAgICBmdW5jdGlvbiByZWFkRmlsZShpbnB1dCwgaW1nRWxlbWVudCkge1xuXG4gICAgICAgIGlmIChpbnB1dC5maWxlcyAmJiBpbnB1dC5maWxlc1swXSkge1xuICAgICAgICAgICAgY29uc29sZS5sb2coJ1JlYWRpbmcgZmlsZScpO1xuICAgICAgICAgICAgdmFyIHJlYWRlciA9IG5ldyBGaWxlUmVhZGVyKCk7XG5cbiAgICAgICAgICAgIHJlYWRlci5yZWFkQXNEYXRhVVJMKGlucHV0LmZpbGVzWzBdKTtcblxuICAgICAgICAgICAgcmVhZGVyLm9ubG9hZCA9IGZ1bmN0aW9uKGUpIHtcbiAgICAgICAgICAgICAgICAkKGltZ0VsZW1lbnQpLmF0dHIoJ3NyYycsIGUudGFyZ2V0LnJlc3VsdCk7XG4gICAgICAgICAgICB9O1xuICAgICAgICB9XG4gICAgfVxuXG4gICAgJChcIi5yZXBseS10b2dnbGVcIikuY2xpY2soZnVuY3Rpb24oKSB7XG4gICAgICAgICQodGhpcykuY2hpbGRyZW4oKS5zaG93KCk7XG4gICAgICAgICQodGhpcykuY2hpbGRyZW4oJy5yZXBseS1idG4nKS5oaWRlKCk7XG4gICAgfSk7XG5cbiAgICAkKCcjYXZhdGFyLWZpbGUnKS5jaGFuZ2UoZnVuY3Rpb24oKSB7XG4gICAgICAgIHJlYWRVUkwodGhpcyk7XG4gICAgfSk7XG5cbiAgICAkKCcjaW1hZ2UnKS5jaGFuZ2UoZnVuY3Rpb24oKSB7XG4gICAgICAgIHJlYWRGaWxlKHRoaXMsICcjcHJldmlldycpO1xuICAgICAgICByZWFkRmlsZSh0aGlzLCAnI3ByZXZpZXctZWRpdCcpO1xuICAgICAgICAkKCcjcHJldmlldycpLnNob3coKTtcbiAgICAgICAgJCgnZGl2LnByZXZpZXctY29udGFpbmVyJykuc2hvdygpO1xuICAgIH0pO1xuXG4gICAgdmFyIGF2YXRhckNyb3BwZXIgPSBuZXcgQ3JvcHBlcihpbWFnZSwge1xuICAgICAgICBhc3BlY3RSYXRpbzogMSxcbiAgICAgICAgY3JvcDogZnVuY3Rpb24oZSkge1xuICAgICAgICAgICAgY29uc29sZS5sb2coZS5kZXRhaWwueCk7XG4gICAgICAgICAgICBjb25zb2xlLmxvZyhlLmRldGFpbC55KTtcbiAgICAgICAgICAgIGNvbnNvbGUubG9nKGUuZGV0YWlsLndpZHRoKTtcbiAgICAgICAgICAgIGNvbnNvbGUubG9nKGUuZGV0YWlsLmhlaWdodCk7XG4gICAgICAgIH1cbiAgICB9KTtcblxuICAgICQoJy5jcm9wLXN1Ym1pdCcpLm9uKCdjbGljaycsIGZ1bmN0aW9uKGUpIHtcbiAgICAgICAgY29uc29sZS5sb2coJ0Nyb3BwaW5nIGF2YXRhcicpO1xuICAgICAgICB2YXIgZm9ybU9iaiA9ICQoJyNhdmF0YXItZm9ybScpO1xuICAgICAgICB2YXIgZm9ybVVSTCA9IGZvcm1PYmouYXR0cihcImFjdGlvblwiKTtcbiAgICAgICAgdmFyIHRva2VuID0gJCgnaW5wdXRbbmFtZT1fdG9rZW5dJyk7XG5cbiAgICAgICAgY29uc29sZS5sb2coZm9ybVVSTCk7XG4gICAgICAgIGF2YXRhckNyb3BwZXIuZ2V0Q3JvcHBlZENhbnZhcygpLnRvQmxvYihmdW5jdGlvbihibG9iKSB7XG4gICAgICAgICAgICB2YXIgZm9ybURhdGEgPSBuZXcgRm9ybURhdGEoKTtcblxuXG4gICAgICAgICAgICBmb3JtRGF0YS5hcHBlbmQoJ2ltYWdlJywgYmxvYik7XG4gICAgICAgICAgICBjb25zb2xlLmxvZyhmb3JtRGF0YSk7XG5cbiAgICAgICAgICAgIC8vIFVzZSBgalF1ZXJ5LmFqYXhgIG1ldGhvZFxuICAgICAgICAgICAgJC5hamF4KHtcbiAgICAgICAgICAgICAgICB1cmw6IGZvcm1VUkwsXG4gICAgICAgICAgICAgICAgbWV0aG9kOiBcIlBPU1RcIixcbiAgICAgICAgICAgICAgICBkYXRhOiBmb3JtRGF0YSxcbiAgICAgICAgICAgICAgICBoZWFkZXJzOiB7XG4gICAgICAgICAgICAgICAgICAgICdYLUNTUkYtVE9LRU4nOiB0b2tlbi52YWwoKVxuICAgICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICAgICAgcHJvY2Vzc0RhdGE6IGZhbHNlLFxuICAgICAgICAgICAgICAgIGNvbnRlbnRUeXBlOiBmYWxzZSxcbiAgICAgICAgICAgICAgICBzdWNjZXNzOiBmdW5jdGlvbigpIHtcbiAgICAgICAgICAgICAgICAgICAgY29uc29sZS5sb2coJ1VwbG9hZCBzdWNjZXNzJyk7XG4gICAgICAgICAgICAgICAgfSxcbiAgICAgICAgICAgICAgICBlcnJvcjogZnVuY3Rpb24oKSB7XG4gICAgICAgICAgICAgICAgICAgIGNvbnNvbGUubG9nKCdVcGxvYWQgZXJyb3InKTtcbiAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICB9KTtcblxuICAgICAgICB9KTtcbiAgICAgICAgZS5wcmV2ZW50RGVmYXVsdCgpO1xuICAgICAgICB3aW5kb3cuc2V0VGltZW91dChmdW5jdGlvbigpIHtcbiAgICAgICAgICAgIGxvY2F0aW9uLnJlbG9hZCgpO1xuICAgICAgICB9LCAyMDAwKVxuICAgIH0pO1xufSk7Il19
