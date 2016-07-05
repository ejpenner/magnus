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

    $('#preview').click(function (e) {
        console.log('hey clicked me');
        // $('#fullview').trigger("unveil").show();
        // $(this).hide();
    });

    $('#fullview').click(function (e) {
        // $(this).hide();
        // $('#preview').show();
    });
});

},{}]},{},[1])
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIi4uLy4uLy5ucG0tbG9jYWwvZ2FsbGVyeS1hcHAvbm9kZV9tb2R1bGVzL2Jyb3dzZXJpZnkvbm9kZV9tb2R1bGVzL2Jyb3dzZXItcGFjay9fcHJlbHVkZS5qcyIsInJlc291cmNlcy9hc3NldHMvanMvYXBwLmpzIl0sIm5hbWVzIjpbXSwibWFwcGluZ3MiOiJBQUFBO0FDQUE7O0FBQ0EsRUFBRSxRQUFGLEVBQVksS0FBWixDQUFrQixZQUFXOztBQUV6QixNQUFFLGdCQUFGLEVBQW9CLFNBQXBCLENBQThCLEdBQTlCOztBQUVBLFdBQU8sVUFBUCxDQUFrQixZQUFXO0FBQ3pCLFVBQUUsZ0JBQUYsRUFBb0IsTUFBcEIsQ0FBMkIsR0FBM0IsRUFBZ0MsQ0FBaEMsRUFBbUMsT0FBbkMsQ0FBMkMsR0FBM0MsRUFBZ0QsWUFBVztBQUN2RCxjQUFFLElBQUYsRUFBUSxNQUFSO0FBQ0gsU0FGRDtBQUdILEtBSkQsRUFJRyxJQUpIOztBQU1BLE1BQUUsaUJBQUYsRUFBcUIsRUFBckIsQ0FBd0IsUUFBeEIsRUFBa0MsWUFBVztBQUN6QyxlQUFPLFFBQVEsdUNBQVIsQ0FBUDtBQUNILEtBRkQ7O0FBSUEsTUFBRSxNQUFGLEVBQVUsTUFBVixDQUFpQixZQUFXO0FBQ3hCLFlBQUksSUFBSSxFQUFFLElBQUYsRUFBUSxTQUFSLEVBQVI7QUFDQSxVQUFFLG9CQUFGLEVBQXdCLEdBQXhCLENBQTRCLHFCQUE1QixFQUFtRCxVQUFVLFNBQVMsQ0FBQyxDQUFWLENBQVYsR0FBeUIsSUFBekIsR0FBZ0MsT0FBaEMsR0FBMEMsU0FBUyxDQUFDLENBQVYsQ0FBMUMsR0FBeUQsZ0JBQTVHO0FBQ0gsS0FIRDs7QUFLQSxRQUFJLFFBQVEsU0FBUyxjQUFULENBQXdCLGdCQUF4QixDQUFaOztBQUVBLGFBQVMsT0FBVCxDQUFpQixLQUFqQixFQUF3Qjs7QUFFcEIsWUFBSSxNQUFNLEtBQU4sSUFBZSxNQUFNLEtBQU4sQ0FBWSxDQUFaLENBQW5CLEVBQW1DO0FBQy9CLG9CQUFRLEdBQVIsQ0FB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LFVBQUUsY0FBRjtBQUNBLGVBQU8sVUFBUCxDQUFrQixZQUFXO0FBQ3pCLHFCQUFTLE1BQVQ7QUFDSCxTQUZELEVBRUcsSUFGSDtBQUdILEtBckNEOztBQXlDQSxNQUFFLFVBQUYsRUFBYyxLQUFkLENBQW9CLFVBQVMsQ0FBVCxFQUFZO0FBQzVCLGdCQUFRLEdBQVIsQ0FBWSxnQkFBWjs7O0FBR0gsS0FKRDs7QUFNQSxNQUFFLFdBQUYsRUFBZSxLQUFmLENBQXFCLFVBQVMsQ0FBVCxFQUFZOzs7QUFHaEMsS0FIRDtBQUlILENBOUhEIiwiZmlsZSI6ImdlbmVyYXRlZC5qcyIsInNvdXJjZVJvb3QiOiIiLCJzb3VyY2VzQ29udGVudCI6WyIoZnVuY3Rpb24gZSh0LG4scil7ZnVuY3Rpb24gcyhvLHUpe2lmKCFuW29dKXtpZighdFtvXSl7dmFyIGE9dHlwZW9mIHJlcXVpcmU9PVwiZnVuY3Rpb25cIiYmcmVxdWlyZTtpZighdSYmYSlyZXR1cm4gYShvLCEwKTtpZihpKXJldHVybiBpKG8sITApO3ZhciBmPW5ldyBFcnJvcihcIkNhbm5vdCBmaW5kIG1vZHVsZSAnXCIrbytcIidcIik7dGhyb3cgZi5jb2RlPVwiTU9EVUxFX05PVF9GT1VORFwiLGZ9dmFyIGw9bltvXT17ZXhwb3J0czp7fX07dFtvXVswXS5jYWxsKGwuZXhwb3J0cyxmdW5jdGlvbihlKXt2YXIgbj10W29dWzFdW2VdO3JldHVybiBzKG4/bjplKX0sbCxsLmV4cG9ydHMsZSx0LG4scil9cmV0dXJuIG5bb10uZXhwb3J0c312YXIgaT10eXBlb2YgcmVxdWlyZT09XCJmdW5jdGlvblwiJiZyZXF1aXJlO2Zvcih2YXIgbz0wO288ci5sZW5ndGg7bysrKXMocltvXSk7cmV0dXJuIHN9KSIsIlwidXNlIHN0cmljdFwiO1xuJChkb2N1bWVudCkucmVhZHkoZnVuY3Rpb24oKSB7XG5cbiAgICAkKFwiLmFsZXJ0LXN1Y2Nlc3NcIikuc2xpZGVEb3duKDQwMCk7XG5cbiAgICB3aW5kb3cuc2V0VGltZW91dChmdW5jdGlvbigpIHtcbiAgICAgICAgJChcIi5hbGVydC1zdWNjZXNzXCIpLmZhZGVUbyg1MDAsIDApLnNsaWRlVXAoNTAwLCBmdW5jdGlvbigpIHtcbiAgICAgICAgICAgICQodGhpcykucmVtb3ZlKCk7XG4gICAgICAgIH0pO1xuICAgIH0sIDMwMDApO1xuXG4gICAgJCgnLmRlbGV0ZS1jb25maXJtJykub24oJ3N1Ym1pdCcsIGZ1bmN0aW9uKCkge1xuICAgICAgICByZXR1cm4gY29uZmlybSgnQXJlIHlvdSBzdXJlIHlvdSB3YW50IHRvIGRlbGV0ZSB0aGlzPycpO1xuICAgIH0pO1xuXG4gICAgJCh3aW5kb3cpLnNjcm9sbChmdW5jdGlvbigpIHtcbiAgICAgICAgdmFyIHggPSAkKHRoaXMpLnNjcm9sbFRvcCgpO1xuICAgICAgICAkKCcjaGVhZGVyLWJhY2tncm91bmQnKS5jc3MoJ2JhY2tncm91bmQtcG9zaXRpb24nLCAnMTAwJSAnICsgcGFyc2VJbnQoLXgpICsgJ3B4JyArICcsIDAlICcgKyBwYXJzZUludCgteCkgKyAncHgsIGNlbnRlciB0b3AnKTtcbiAgICB9KTtcblxuICAgIHZhciBpbWFnZSA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdhdmF0YXItY3JvcHBlcicpO1xuXG4gICAgZnVuY3Rpb24gcmVhZFVSTChpbnB1dCkge1xuXG4gICAgICAgIGlmIChpbnB1dC5maWxlcyAmJiBpbnB1dC5maWxlc1swXSkge1xuICAgICAgICAgICAgY29uc29sZS5sb2coJ1JlYWRpbmcgZmlsZScpO1xuICAgICAgICAgICAgdmFyIHJlYWRlciA9IG5ldyBGaWxlUmVhZGVyKCk7XG5cbiAgICAgICAgICAgIHJlYWRlci5yZWFkQXNEYXRhVVJMKGlucHV0LmZpbGVzWzBdKTtcblxuICAgICAgICAgICAgcmVhZGVyLm9ubG9hZCA9IGZ1bmN0aW9uKGUpIHtcbiAgICAgICAgICAgICAgICBhdmF0YXJDcm9wcGVyLnJlcGxhY2UoZS50YXJnZXQucmVzdWx0KTtcbiAgICAgICAgICAgIH07XG4gICAgICAgIH1cbiAgICB9XG5cbiAgICBmdW5jdGlvbiByZWFkRmlsZShpbnB1dCwgaW1nRWxlbWVudCkge1xuXG4gICAgICAgIGlmIChpbnB1dC5maWxlcyAmJiBpbnB1dC5maWxlc1swXSkge1xuICAgICAgICAgICAgY29uc29sZS5sb2coJ1JlYWRpbmcgZmlsZScpO1xuICAgICAgICAgICAgdmFyIHJlYWRlciA9IG5ldyBGaWxlUmVhZGVyKCk7XG5cbiAgICAgICAgICAgIHJlYWRlci5yZWFkQXNEYXRhVVJMKGlucHV0LmZpbGVzWzBdKTtcblxuICAgICAgICAgICAgcmVhZGVyLm9ubG9hZCA9IGZ1bmN0aW9uKGUpIHtcbiAgICAgICAgICAgICAgICAkKGltZ0VsZW1lbnQpLmF0dHIoJ3NyYycsIGUudGFyZ2V0LnJlc3VsdCk7XG4gICAgICAgICAgICB9O1xuICAgICAgICB9XG4gICAgfVxuXG4gICAgJChcIi5yZXBseS10b2dnbGVcIikuY2xpY2soZnVuY3Rpb24oKSB7XG4gICAgICAgICQodGhpcykuY2hpbGRyZW4oKS5zaG93KCk7XG4gICAgICAgICQodGhpcykuY2hpbGRyZW4oJy5yZXBseS1idG4nKS5oaWRlKCk7XG4gICAgfSk7XG5cbiAgICAkKCcjYXZhdGFyLWZpbGUnKS5jaGFuZ2UoZnVuY3Rpb24oKSB7XG4gICAgICAgIHJlYWRVUkwodGhpcyk7XG4gICAgfSk7XG5cbiAgICAkKCcjaW1hZ2UnKS5jaGFuZ2UoZnVuY3Rpb24oKSB7XG4gICAgICAgIHJlYWRGaWxlKHRoaXMsICcjcHJldmlldycpO1xuICAgICAgICByZWFkRmlsZSh0aGlzLCAnI3ByZXZpZXctZWRpdCcpO1xuICAgICAgICAkKCcjcHJldmlldycpLnNob3coKTtcbiAgICAgICAgJCgnZGl2LnByZXZpZXctY29udGFpbmVyJykuc2hvdygpO1xuICAgIH0pO1xuXG4gICAgdmFyIGF2YXRhckNyb3BwZXIgPSBuZXcgQ3JvcHBlcihpbWFnZSwge1xuICAgICAgICBhc3BlY3RSYXRpbzogMSxcbiAgICAgICAgY3JvcDogZnVuY3Rpb24oZSkge1xuICAgICAgICAgICAgY29uc29sZS5sb2coZS5kZXRhaWwueCk7XG4gICAgICAgICAgICBjb25zb2xlLmxvZyhlLmRldGFpbC55KTtcbiAgICAgICAgICAgIGNvbnNvbGUubG9nKGUuZGV0YWlsLndpZHRoKTtcbiAgICAgICAgICAgIGNvbnNvbGUubG9nKGUuZGV0YWlsLmhlaWdodCk7XG4gICAgICAgIH1cbiAgICB9KTtcblxuICAgICQoJy5jcm9wLXN1Ym1pdCcpLm9uKCdjbGljaycsIGZ1bmN0aW9uKGUpIHtcbiAgICAgICAgY29uc29sZS5sb2coJ0Nyb3BwaW5nIGF2YXRhcicpO1xuICAgICAgICB2YXIgZm9ybU9iaiA9ICQoJyNhdmF0YXItZm9ybScpO1xuICAgICAgICB2YXIgZm9ybVVSTCA9IGZvcm1PYmouYXR0cihcImFjdGlvblwiKTtcbiAgICAgICAgdmFyIHRva2VuID0gJCgnaW5wdXRbbmFtZT1fdG9rZW5dJyk7XG5cbiAgICAgICAgY29uc29sZS5sb2coZm9ybVVSTCk7XG4gICAgICAgIGF2YXRhckNyb3BwZXIuZ2V0Q3JvcHBlZENhbnZhcygpLnRvQmxvYihmdW5jdGlvbihibG9iKSB7XG4gICAgICAgICAgICB2YXIgZm9ybURhdGEgPSBuZXcgRm9ybURhdGEoKTtcblxuXG4gICAgICAgICAgICBmb3JtRGF0YS5hcHBlbmQoJ2ltYWdlJywgYmxvYik7XG4gICAgICAgICAgICBjb25zb2xlLmxvZyhmb3JtRGF0YSk7XG5cbiAgICAgICAgICAgIC8vIFVzZSBgalF1ZXJ5LmFqYXhgIG1ldGhvZFxuICAgICAgICAgICAgJC5hamF4KHtcbiAgICAgICAgICAgICAgICB1cmw6IGZvcm1VUkwsXG4gICAgICAgICAgICAgICAgbWV0aG9kOiBcIlBPU1RcIixcbiAgICAgICAgICAgICAgICBkYXRhOiBmb3JtRGF0YSxcbiAgICAgICAgICAgICAgICBoZWFkZXJzOiB7XG4gICAgICAgICAgICAgICAgICAgICdYLUNTUkYtVE9LRU4nOiB0b2tlbi52YWwoKVxuICAgICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICAgICAgcHJvY2Vzc0RhdGE6IGZhbHNlLFxuICAgICAgICAgICAgICAgIGNvbnRlbnRUeXBlOiBmYWxzZSxcbiAgICAgICAgICAgICAgICBzdWNjZXNzOiBmdW5jdGlvbigpIHtcbiAgICAgICAgICAgICAgICAgICAgY29uc29sZS5sb2coJ1VwbG9hZCBzdWNjZXNzJyk7XG4gICAgICAgICAgICAgICAgfSxcbiAgICAgICAgICAgICAgICBlcnJvcjogZnVuY3Rpb24oKSB7XG4gICAgICAgICAgICAgICAgICAgIGNvbnNvbGUubG9nKCdVcGxvYWQgZXJyb3InKTtcbiAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICB9KTtcblxuICAgICAgICB9KTtcbiAgICAgICAgZS5wcmV2ZW50RGVmYXVsdCgpO1xuICAgICAgICB3aW5kb3cuc2V0VGltZW91dChmdW5jdGlvbigpIHtcbiAgICAgICAgICAgIGxvY2F0aW9uLnJlbG9hZCgpO1xuICAgICAgICB9LCAyMDAwKVxuICAgIH0pO1xuXG5cblxuICAgICQoJyNwcmV2aWV3JykuY2xpY2soZnVuY3Rpb24oZSkge1xuICAgICAgICBjb25zb2xlLmxvZygnaGV5IGNsaWNrZWQgbWUnKTtcbiAgICAgICAgLy8gJCgnI2Z1bGx2aWV3JykudHJpZ2dlcihcInVudmVpbFwiKS5zaG93KCk7XG4gICAgICAgIC8vICQodGhpcykuaGlkZSgpO1xuICAgIH0pO1xuXG4gICAgJCgnI2Z1bGx2aWV3JykuY2xpY2soZnVuY3Rpb24oZSkge1xuICAgICAgICAvLyAkKHRoaXMpLmhpZGUoKTtcbiAgICAgICAgLy8gJCgnI3ByZXZpZXcnKS5zaG93KCk7XG4gICAgfSk7XG59KTsiXX0=
