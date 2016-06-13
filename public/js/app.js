(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
"use strict";

$(document).ready(function () {

    window.setTimeout(function () {
        $(".alert-success").fadeTo(500, 0).slideUp(500, function () {
            $(this).remove();
        });
    }, 3000);

    $('.delete-confirm').on('submit', function () {
        return confirm('Are you sure you want to delete this?');
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
                cropper.replace(e.target.result);
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
    });

    var cropper = new Cropper(image, {
        aspectRatio: 1 / 1,
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
        cropper.getCroppedCanvas().toBlob(function (blob) {
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
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIi4uLy4uLy5ucG0tbG9jYWwvZ2FsbGVyeS1hcHAvbm9kZV9tb2R1bGVzL2Jyb3dzZXJpZnkvbm9kZV9tb2R1bGVzL2Jyb3dzZXItcGFjay9fcHJlbHVkZS5qcyIsInJlc291cmNlcy9hc3NldHMvanMvYXBwLmpzIl0sIm5hbWVzIjpbXSwibWFwcGluZ3MiOiJBQUFBO0FDQUE7O0FBQ0EsRUFBRSxRQUFGLEVBQVksS0FBWixDQUFrQixZQUFXOztBQUV6QixXQUFPLFVBQVAsQ0FBa0IsWUFBVztBQUN6QixVQUFFLGdCQUFGLEVBQW9CLE1BQXBCLENBQTJCLEdBQTNCLEVBQWdDLENBQWhDLEVBQW1DLE9BQW5DLENBQTJDLEdBQTNDLEVBQWdELFlBQVc7QUFDdkQsY0FBRSxJQUFGLEVBQVEsTUFBUjtBQUNILFNBRkQ7QUFHSCxLQUpELEVBSUcsSUFKSDs7QUFNQSxNQUFFLGlCQUFGLEVBQXFCLEVBQXJCLENBQXdCLFFBQXhCLEVBQWtDLFlBQVc7QUFDekMsZUFBTyxRQUFRLHVDQUFSLENBQVA7QUFDSCxLQUZEOztBQUlBLE1BQUUsTUFBRixFQUFVLE1BQVYsQ0FBaUIsWUFBVztBQUN4QixZQUFJLElBQUksRUFBRSxJQUFGLEVBQVEsU0FBUixFQUFSO0FBQ0EsVUFBRSxvQkFBRixFQUF3QixHQUF4QixDQUE0QixxQkFBNUIsRUFBbUQsVUFBVSxTQUFTLENBQUMsQ0FBVixDQUFWLEdBQXlCLElBQXpCLEdBQWdDLE9BQWhDLEdBQTBDLFNBQVMsQ0FBQyxDQUFWLENBQTFDLEdBQXlELGdCQUE1RztBQUNILEtBSEQ7O0FBS0EsUUFBSSxRQUFRLFNBQVMsY0FBVCxDQUF3QixnQkFBeEIsQ0FBWjs7QUFFQSxhQUFTLE9BQVQsQ0FBaUIsS0FBakIsRUFBd0I7O0FBRXBCLFlBQUksTUFBTSxLQUFOLElBQWUsTUFBTSxLQUFOLENBQVksQ0FBWixDQUFuQixFQUFtQztBQUMvQixvQkFBUSxHQUFSLENBQVksY0FBWjtBQUNBLGdCQUFJLFNBQVMsSUFBSSxVQUFKLEVBQWI7O0FB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LElBRkg7QUFHSCxLQXJDRDtBQXVDSCxDQWhIRCIsImZpbGUiOiJnZW5lcmF0ZWQuanMiLCJzb3VyY2VSb290IjoiIiwic291cmNlc0NvbnRlbnQiOlsiKGZ1bmN0aW9uIGUodCxuLHIpe2Z1bmN0aW9uIHMobyx1KXtpZighbltvXSl7aWYoIXRbb10pe3ZhciBhPXR5cGVvZiByZXF1aXJlPT1cImZ1bmN0aW9uXCImJnJlcXVpcmU7aWYoIXUmJmEpcmV0dXJuIGEobywhMCk7aWYoaSlyZXR1cm4gaShvLCEwKTt2YXIgZj1uZXcgRXJyb3IoXCJDYW5ub3QgZmluZCBtb2R1bGUgJ1wiK28rXCInXCIpO3Rocm93IGYuY29kZT1cIk1PRFVMRV9OT1RfRk9VTkRcIixmfXZhciBsPW5bb109e2V4cG9ydHM6e319O3Rbb11bMF0uY2FsbChsLmV4cG9ydHMsZnVuY3Rpb24oZSl7dmFyIG49dFtvXVsxXVtlXTtyZXR1cm4gcyhuP246ZSl9LGwsbC5leHBvcnRzLGUsdCxuLHIpfXJldHVybiBuW29dLmV4cG9ydHN9dmFyIGk9dHlwZW9mIHJlcXVpcmU9PVwiZnVuY3Rpb25cIiYmcmVxdWlyZTtmb3IodmFyIG89MDtvPHIubGVuZ3RoO28rKylzKHJbb10pO3JldHVybiBzfSkiLCJcInVzZSBzdHJpY3RcIjtcbiQoZG9jdW1lbnQpLnJlYWR5KGZ1bmN0aW9uKCkge1xyXG5cclxuICAgIHdpbmRvdy5zZXRUaW1lb3V0KGZ1bmN0aW9uKCkge1xyXG4gICAgICAgICQoXCIuYWxlcnQtc3VjY2Vzc1wiKS5mYWRlVG8oNTAwLCAwKS5zbGlkZVVwKDUwMCwgZnVuY3Rpb24oKSB7XHJcbiAgICAgICAgICAgICQodGhpcykucmVtb3ZlKCk7XHJcbiAgICAgICAgfSk7XHJcbiAgICB9LCAzMDAwKTtcclxuXHJcbiAgICAkKCcuZGVsZXRlLWNvbmZpcm0nKS5vbignc3VibWl0JywgZnVuY3Rpb24oKSB7XHJcbiAgICAgICAgcmV0dXJuIGNvbmZpcm0oJ0FyZSB5b3Ugc3VyZSB5b3Ugd2FudCB0byBkZWxldGUgdGhpcz8nKTtcclxuICAgIH0pO1xyXG5cclxuICAgICQod2luZG93KS5zY3JvbGwoZnVuY3Rpb24oKSB7XHJcbiAgICAgICAgdmFyIHggPSAkKHRoaXMpLnNjcm9sbFRvcCgpO1xyXG4gICAgICAgICQoJyNoZWFkZXItYmFja2dyb3VuZCcpLmNzcygnYmFja2dyb3VuZC1wb3NpdGlvbicsICcxMDAlICcgKyBwYXJzZUludCgteCkgKyAncHgnICsgJywgMCUgJyArIHBhcnNlSW50KC14KSArICdweCwgY2VudGVyIHRvcCcpO1xyXG4gICAgfSk7XHJcblxyXG4gICAgdmFyIGltYWdlID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ2F2YXRhci1jcm9wcGVyJyk7XHJcblxyXG4gICAgZnVuY3Rpb24gcmVhZFVSTChpbnB1dCkge1xyXG5cclxuICAgICAgICBpZiAoaW5wdXQuZmlsZXMgJiYgaW5wdXQuZmlsZXNbMF0pIHtcclxuICAgICAgICAgICAgY29uc29sZS5sb2coJ1JlYWRpbmcgZmlsZScpO1xyXG4gICAgICAgICAgICB2YXIgcmVhZGVyID0gbmV3IEZpbGVSZWFkZXIoKTtcclxuXHJcbiAgICAgICAgICAgIHJlYWRlci5yZWFkQXNEYXRhVVJMKGlucHV0LmZpbGVzWzBdKTtcclxuXHJcbiAgICAgICAgICAgIHJlYWRlci5vbmxvYWQgPSBmdW5jdGlvbihlKSB7XHJcbiAgICAgICAgICAgICAgICBjcm9wcGVyLnJlcGxhY2UoZS50YXJnZXQucmVzdWx0KTtcclxuICAgICAgICAgICAgfTtcclxuICAgICAgICB9XHJcbiAgICB9XHJcblxyXG4gICAgZnVuY3Rpb24gcmVhZEZpbGUoaW5wdXQsIGltZ0VsZW1lbnQpIHtcclxuXHJcbiAgICAgICAgaWYgKGlucHV0LmZpbGVzICYmIGlucHV0LmZpbGVzWzBdKSB7XHJcbiAgICAgICAgICAgIGNvbnNvbGUubG9nKCdSZWFkaW5nIGZpbGUnKTtcclxuICAgICAgICAgICAgdmFyIHJlYWRlciA9IG5ldyBGaWxlUmVhZGVyKCk7XHJcblxyXG4gICAgICAgICAgICByZWFkZXIucmVhZEFzRGF0YVVSTChpbnB1dC5maWxlc1swXSk7XHJcblxyXG4gICAgICAgICAgICByZWFkZXIub25sb2FkID0gZnVuY3Rpb24oZSkge1xyXG4gICAgICAgICAgICAgICAgJChpbWdFbGVtZW50KS5hdHRyKCdzcmMnLCBlLnRhcmdldC5yZXN1bHQpO1xyXG4gICAgICAgICAgICB9O1xyXG4gICAgICAgIH1cclxuICAgIH1cclxuXHJcbiAgICAkKFwiLnJlcGx5LXRvZ2dsZVwiKS5jbGljayhmdW5jdGlvbigpIHtcclxuICAgICAgICAkKHRoaXMpLmNoaWxkcmVuKCkuc2hvdygpO1xyXG4gICAgICAgICQodGhpcykuY2hpbGRyZW4oJy5yZXBseS1idG4nKS5oaWRlKCk7XHJcbiAgICB9KTtcclxuXHJcbiAgICAkKCcjYXZhdGFyLWZpbGUnKS5jaGFuZ2UoZnVuY3Rpb24oKSB7XHJcbiAgICAgICAgcmVhZFVSTCh0aGlzKTtcclxuXHJcbiAgICB9KTtcclxuXHJcbiAgICAkKCcjaW1hZ2UnKS5jaGFuZ2UoZnVuY3Rpb24oKSB7XHJcbiAgICAgICAgcmVhZEZpbGUodGhpcywgJyNwcmV2aWV3Jyk7XHJcbiAgICAgICAgcmVhZEZpbGUodGhpcywgJyNwcmV2aWV3LWVkaXQnKTtcclxuICAgICAgICAkKCcjcHJldmlldycpLnNob3coKTtcclxuICAgIH0pO1xyXG5cclxuICAgIHZhciBjcm9wcGVyID0gbmV3IENyb3BwZXIoaW1hZ2UsIHtcclxuICAgICAgICBhc3BlY3RSYXRpbzogMSAvIDEsXHJcbiAgICAgICAgY3JvcDogZnVuY3Rpb24oZSkge1xyXG4gICAgICAgICAgICBjb25zb2xlLmxvZyhlLmRldGFpbC54KTtcclxuICAgICAgICAgICAgY29uc29sZS5sb2coZS5kZXRhaWwueSk7XHJcbiAgICAgICAgICAgIGNvbnNvbGUubG9nKGUuZGV0YWlsLndpZHRoKTtcclxuICAgICAgICAgICAgY29uc29sZS5sb2coZS5kZXRhaWwuaGVpZ2h0KTtcclxuICAgICAgICB9XHJcbiAgICB9KTtcclxuXHJcbiAgICAkKCcuY3JvcC1zdWJtaXQnKS5vbignY2xpY2snLCBmdW5jdGlvbihlKSB7XHJcbiAgICAgICAgY29uc29sZS5sb2coJ0Nyb3BwaW5nIGF2YXRhcicpO1xyXG4gICAgICAgIHZhciBmb3JtT2JqID0gJCgnI2F2YXRhci1mb3JtJyk7XHJcbiAgICAgICAgdmFyIGZvcm1VUkwgPSBmb3JtT2JqLmF0dHIoXCJhY3Rpb25cIik7XHJcbiAgICAgICAgdmFyIHRva2VuID0gJCgnaW5wdXRbbmFtZT1fdG9rZW5dJyk7XHJcblxyXG4gICAgICAgIGNvbnNvbGUubG9nKGZvcm1VUkwpO1xyXG4gICAgICAgIGNyb3BwZXIuZ2V0Q3JvcHBlZENhbnZhcygpLnRvQmxvYihmdW5jdGlvbihibG9iKSB7XHJcbiAgICAgICAgICAgIHZhciBmb3JtRGF0YSA9IG5ldyBGb3JtRGF0YSgpO1xyXG5cclxuXHJcbiAgICAgICAgICAgIGZvcm1EYXRhLmFwcGVuZCgnaW1hZ2UnLCBibG9iKTtcclxuICAgICAgICAgICAgY29uc29sZS5sb2coZm9ybURhdGEpO1xyXG5cclxuICAgICAgICAgICAgLy8gVXNlIGBqUXVlcnkuYWpheGAgbWV0aG9kXHJcbiAgICAgICAgICAgICQuYWpheCh7XHJcbiAgICAgICAgICAgICAgICB1cmw6IGZvcm1VUkwsXHJcbiAgICAgICAgICAgICAgICBtZXRob2Q6IFwiUE9TVFwiLFxyXG4gICAgICAgICAgICAgICAgZGF0YTogZm9ybURhdGEsXHJcbiAgICAgICAgICAgICAgICBoZWFkZXJzOiB7XHJcbiAgICAgICAgICAgICAgICAgICAgJ1gtQ1NSRi1UT0tFTic6IHRva2VuLnZhbCgpXHJcbiAgICAgICAgICAgICAgICB9LFxyXG4gICAgICAgICAgICAgICAgcHJvY2Vzc0RhdGE6IGZhbHNlLFxyXG4gICAgICAgICAgICAgICAgY29udGVudFR5cGU6IGZhbHNlLFxyXG4gICAgICAgICAgICAgICAgc3VjY2VzczogZnVuY3Rpb24oKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgY29uc29sZS5sb2coJ1VwbG9hZCBzdWNjZXNzJyk7XHJcbiAgICAgICAgICAgICAgICB9LFxyXG4gICAgICAgICAgICAgICAgZXJyb3I6IGZ1bmN0aW9uKCkge1xyXG4gICAgICAgICAgICAgICAgICAgIGNvbnNvbGUubG9nKCdVcGxvYWQgZXJyb3InKTtcclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgfSk7XHJcblxyXG4gICAgICAgIH0pO1xyXG4gICAgICAgIGUucHJldmVudERlZmF1bHQoKTtcclxuICAgICAgICB3aW5kb3cuc2V0VGltZW91dChmdW5jdGlvbigpIHtcclxuICAgICAgICAgICAgbG9jYXRpb24ucmVsb2FkKCk7XHJcbiAgICAgICAgfSwgMjAwMClcclxuICAgIH0pO1xyXG5cclxufSk7Il19
