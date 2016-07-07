(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
"use strict";

$(document).ready(function () {

    window.setTimeout(function () {
        $('.alert-success').fadeTo(500, 0).slideUp(500, function () {
            $(this).remove();
        });
    }, 3000);

    $('.delete-confirm').on('submit', function () {
        return confirm('Are you sure you want to delete this?');
    });

    $('#preview').click(function () {
        $('#fullview').show().unveil();
        $(this).toggle();
    });

    $('#fullview').click(function () {
        $(this).toggle();
        $('#preview').toggle();
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

    $('.reply-toggle').click(function () {
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

    try {
        var avatarCropper = new Cropper(image, {
            aspectRatio: 1,
            crop: function (e) {
                // console.log(e.detail.x);
                // console.log(e.detail.y);
                // console.log(e.detail.width);
                // console.log(e.detail.height);
            }
        });
    } catch (e) {}

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
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIi4uLy4uLy5ucG0tbG9jYWwvZ2FsbGVyeS1hcHAvbm9kZV9tb2R1bGVzL2Jyb3dzZXJpZnkvbm9kZV9tb2R1bGVzL2Jyb3dzZXItcGFjay9fcHJlbHVkZS5qcyIsInJlc291cmNlcy9hc3NldHMvanMvYXBwLmpzIl0sIm5hbWVzIjpbXSwibWFwcGluZ3MiOiJBQUFBO0FDQUE7O0FBQ0EsRUFBRSxRQUFGLEVBQVksS0FBWixDQUFrQixZQUFXOztBQUV6QixXQUFPLFVBQVAsQ0FBa0IsWUFBVztBQUN6QixVQUFFLGdCQUFGLEVBQW9CLE1BQXBCLENBQTJCLEdBQTNCLEVBQWdDLENBQWhDLEVBQW1DLE9BQW5DLENBQTJDLEdBQTNDLEVBQWdELFlBQVc7QUFDdkQsY0FBRSxJQUFGLEVBQVEsTUFBUjtBQUNILFNBRkQ7QUFHSCxLQUpELEVBSUcsSUFKSDs7QUFNQSxNQUFFLGlCQUFGLEVBQXFCLEVBQXJCLENBQXdCLFFBQXhCLEVBQWtDLFlBQVc7QUFDekMsZUFBTyxRQUFRLHVDQUFSLENBQVA7QUFDSCxLQUZEOztBQUlBLE1BQUUsVUFBRixFQUFjLEtBQWQsQ0FBb0IsWUFBVztBQUMzQixVQUFFLFdBQUYsRUFBZSxJQUFmLEdBQXNCLE1BQXRCO0FBQ0EsVUFBRSxJQUFGLEVBQVEsTUFBUjtBQUNILEtBSEQ7O0FBS0EsTUFBRSxXQUFGLEVBQWUsS0FBZixDQUFxQixZQUFXO0FBQzVCLFVBQUUsSUFBRixFQUFRLE1BQVI7QUFDQSxVQUFFLFVBQUYsRUFBYyxNQUFkO0FBQ0gsS0FIRDs7QUFNQSxNQUFFLE1BQUYsRUFBVSxNQUFWLENBQWlCLFlBQVc7QUFDeEIsWUFBSSxJQUFJLEVBQUUsSUFBRixFQUFRLFNBQVIsRUFBUjtBQUNBLFVBQUUsb0JBQUYsRUFBd0IsR0FBeEIsQ0FBNEIscUJBQTVCLEVBQW1ELFVBQVUsU0FBUyxDQUFDLENBQVYsQ0FBVixHQUF5QixJQUF6QixHQUFnQyxPQUFoQyxHQUEwQyxTQUFTLENBQUMsQ0FBVixDQUExQyxHQUF5RCxnQkFBNUc7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QVEsR0FBUixDQUFZLGNBQVo7QUFDSDtBQWRFLGFBQVA7QUFpQkgsU0F6QkQ7QUEwQkEsVUFBRSxjQUFGO0FBQ0EsZUFBTyxVQUFQLENBQWtCLFlBQVc7QUFDekIscUJBQVMsTUFBVDtBQUNILFNBRkQsRUFFRyxJQUZIO0FBR0gsS0FyQ0Q7QUFzQ0gsQ0E1SEQiLCJmaWxlIjoiZ2VuZXJhdGVkLmpzIiwic291cmNlUm9vdCI6IiIsInNvdXJjZXNDb250ZW50IjpbIihmdW5jdGlvbiBlKHQsbixyKXtmdW5jdGlvbiBzKG8sdSl7aWYoIW5bb10pe2lmKCF0W29dKXt2YXIgYT10eXBlb2YgcmVxdWlyZT09XCJmdW5jdGlvblwiJiZyZXF1aXJlO2lmKCF1JiZhKXJldHVybiBhKG8sITApO2lmKGkpcmV0dXJuIGkobywhMCk7dmFyIGY9bmV3IEVycm9yKFwiQ2Fubm90IGZpbmQgbW9kdWxlICdcIitvK1wiJ1wiKTt0aHJvdyBmLmNvZGU9XCJNT0RVTEVfTk9UX0ZPVU5EXCIsZn12YXIgbD1uW29dPXtleHBvcnRzOnt9fTt0W29dWzBdLmNhbGwobC5leHBvcnRzLGZ1bmN0aW9uKGUpe3ZhciBuPXRbb11bMV1bZV07cmV0dXJuIHMobj9uOmUpfSxsLGwuZXhwb3J0cyxlLHQsbixyKX1yZXR1cm4gbltvXS5leHBvcnRzfXZhciBpPXR5cGVvZiByZXF1aXJlPT1cImZ1bmN0aW9uXCImJnJlcXVpcmU7Zm9yKHZhciBvPTA7bzxyLmxlbmd0aDtvKyspcyhyW29dKTtyZXR1cm4gc30pIiwiXCJ1c2Ugc3RyaWN0XCI7XG4kKGRvY3VtZW50KS5yZWFkeShmdW5jdGlvbigpIHtcblxuICAgIHdpbmRvdy5zZXRUaW1lb3V0KGZ1bmN0aW9uKCkge1xuICAgICAgICAkKCcuYWxlcnQtc3VjY2VzcycpLmZhZGVUbyg1MDAsIDApLnNsaWRlVXAoNTAwLCBmdW5jdGlvbigpIHtcbiAgICAgICAgICAgICQodGhpcykucmVtb3ZlKCk7XG4gICAgICAgIH0pO1xuICAgIH0sIDMwMDApO1xuXG4gICAgJCgnLmRlbGV0ZS1jb25maXJtJykub24oJ3N1Ym1pdCcsIGZ1bmN0aW9uKCkge1xuICAgICAgICByZXR1cm4gY29uZmlybSgnQXJlIHlvdSBzdXJlIHlvdSB3YW50IHRvIGRlbGV0ZSB0aGlzPycpO1xuICAgIH0pO1xuXG4gICAgJCgnI3ByZXZpZXcnKS5jbGljayhmdW5jdGlvbigpIHtcbiAgICAgICAgJCgnI2Z1bGx2aWV3Jykuc2hvdygpLnVudmVpbCgpO1xuICAgICAgICAkKHRoaXMpLnRvZ2dsZSgpO1xuICAgIH0pO1xuXG4gICAgJCgnI2Z1bGx2aWV3JykuY2xpY2soZnVuY3Rpb24oKSB7XG4gICAgICAgICQodGhpcykudG9nZ2xlKCk7XG4gICAgICAgICQoJyNwcmV2aWV3JykudG9nZ2xlKCk7XG4gICAgfSk7XG5cblxuICAgICQod2luZG93KS5zY3JvbGwoZnVuY3Rpb24oKSB7XG4gICAgICAgIHZhciB4ID0gJCh0aGlzKS5zY3JvbGxUb3AoKTtcbiAgICAgICAgJCgnI2hlYWRlci1iYWNrZ3JvdW5kJykuY3NzKCdiYWNrZ3JvdW5kLXBvc2l0aW9uJywgJzEwMCUgJyArIHBhcnNlSW50KC14KSArICdweCcgKyAnLCAwJSAnICsgcGFyc2VJbnQoLXgpICsgJ3B4LCBjZW50ZXIgdG9wJyk7XG4gICAgfSk7XG5cbiAgICB2YXIgaW1hZ2UgPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgnYXZhdGFyLWNyb3BwZXInKTtcblxuICAgIGZ1bmN0aW9uIHJlYWRVUkwoaW5wdXQpIHtcblxuICAgICAgICBpZiAoaW5wdXQuZmlsZXMgJiYgaW5wdXQuZmlsZXNbMF0pIHtcbiAgICAgICAgICAgIGNvbnNvbGUubG9nKCdSZWFkaW5nIGZpbGUnKTtcbiAgICAgICAgICAgIHZhciByZWFkZXIgPSBuZXcgRmlsZVJlYWRlcigpO1xuXG4gICAgICAgICAgICByZWFkZXIucmVhZEFzRGF0YVVSTChpbnB1dC5maWxlc1swXSk7XG5cbiAgICAgICAgICAgIHJlYWRlci5vbmxvYWQgPSBmdW5jdGlvbihlKSB7XG4gICAgICAgICAgICAgICAgYXZhdGFyQ3JvcHBlci5yZXBsYWNlKGUudGFyZ2V0LnJlc3VsdCk7XG4gICAgICAgICAgICB9O1xuICAgICAgICB9XG4gICAgfVxuXG4gICAgZnVuY3Rpb24gcmVhZEZpbGUoaW5wdXQsIGltZ0VsZW1lbnQpIHtcblxuICAgICAgICBpZiAoaW5wdXQuZmlsZXMgJiYgaW5wdXQuZmlsZXNbMF0pIHtcbiAgICAgICAgICAgIGNvbnNvbGUubG9nKCdSZWFkaW5nIGZpbGUnKTtcbiAgICAgICAgICAgIHZhciByZWFkZXIgPSBuZXcgRmlsZVJlYWRlcigpO1xuXG4gICAgICAgICAgICByZWFkZXIucmVhZEFzRGF0YVVSTChpbnB1dC5maWxlc1swXSk7XG5cbiAgICAgICAgICAgIHJlYWRlci5vbmxvYWQgPSBmdW5jdGlvbihlKSB7XG4gICAgICAgICAgICAgICAgJChpbWdFbGVtZW50KS5hdHRyKCdzcmMnLCBlLnRhcmdldC5yZXN1bHQpO1xuICAgICAgICAgICAgfTtcbiAgICAgICAgfVxuICAgIH1cblxuICAgICQoJy5yZXBseS10b2dnbGUnKS5jbGljayhmdW5jdGlvbigpIHtcbiAgICAgICAgJCh0aGlzKS5jaGlsZHJlbigpLnNob3coKTtcbiAgICAgICAgJCh0aGlzKS5jaGlsZHJlbignLnJlcGx5LWJ0bicpLmhpZGUoKTtcbiAgICB9KTtcblxuICAgICQoJyNhdmF0YXItZmlsZScpLmNoYW5nZShmdW5jdGlvbigpIHtcbiAgICAgICAgcmVhZFVSTCh0aGlzKTtcbiAgICB9KTtcblxuICAgICQoJyNpbWFnZScpLmNoYW5nZShmdW5jdGlvbigpIHtcbiAgICAgICAgcmVhZEZpbGUodGhpcywgJyNwcmV2aWV3Jyk7XG4gICAgICAgIHJlYWRGaWxlKHRoaXMsICcjcHJldmlldy1lZGl0Jyk7XG4gICAgICAgICQoJyNwcmV2aWV3Jykuc2hvdygpO1xuICAgICAgICAkKCdkaXYucHJldmlldy1jb250YWluZXInKS5zaG93KCk7XG4gICAgfSk7XG5cbiAgICB0cnkge1xuICAgICAgICB2YXIgYXZhdGFyQ3JvcHBlciA9IG5ldyBDcm9wcGVyKGltYWdlLCB7XG4gICAgICAgICAgICBhc3BlY3RSYXRpbzogMSxcbiAgICAgICAgICAgIGNyb3A6IGZ1bmN0aW9uKGUpIHtcbiAgICAgICAgICAgICAgICAvLyBjb25zb2xlLmxvZyhlLmRldGFpbC54KTtcbiAgICAgICAgICAgICAgICAvLyBjb25zb2xlLmxvZyhlLmRldGFpbC55KTtcbiAgICAgICAgICAgICAgICAvLyBjb25zb2xlLmxvZyhlLmRldGFpbC53aWR0aCk7XG4gICAgICAgICAgICAgICAgLy8gY29uc29sZS5sb2coZS5kZXRhaWwuaGVpZ2h0KTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgfSk7XG4gICAgfSBjYXRjaCAoZSkge31cblxuICAgICQoJy5jcm9wLXN1Ym1pdCcpLm9uKCdjbGljaycsIGZ1bmN0aW9uKGUpIHtcbiAgICAgICAgY29uc29sZS5sb2coJ0Nyb3BwaW5nIGF2YXRhcicpO1xuICAgICAgICB2YXIgZm9ybU9iaiA9ICQoJyNhdmF0YXItZm9ybScpO1xuICAgICAgICB2YXIgZm9ybVVSTCA9IGZvcm1PYmouYXR0cihcImFjdGlvblwiKTtcbiAgICAgICAgdmFyIHRva2VuID0gJCgnaW5wdXRbbmFtZT1fdG9rZW5dJyk7XG5cbiAgICAgICAgY29uc29sZS5sb2coZm9ybVVSTCk7XG4gICAgICAgIGF2YXRhckNyb3BwZXIuZ2V0Q3JvcHBlZENhbnZhcygpLnRvQmxvYihmdW5jdGlvbihibG9iKSB7XG4gICAgICAgICAgICB2YXIgZm9ybURhdGEgPSBuZXcgRm9ybURhdGEoKTtcblxuXG4gICAgICAgICAgICBmb3JtRGF0YS5hcHBlbmQoJ2ltYWdlJywgYmxvYik7XG4gICAgICAgICAgICBjb25zb2xlLmxvZyhmb3JtRGF0YSk7XG5cbiAgICAgICAgICAgIC8vIFVzZSBgalF1ZXJ5LmFqYXhgIG1ldGhvZFxuICAgICAgICAgICAgJC5hamF4KHtcbiAgICAgICAgICAgICAgICB1cmw6IGZvcm1VUkwsXG4gICAgICAgICAgICAgICAgbWV0aG9kOiBcIlBPU1RcIixcbiAgICAgICAgICAgICAgICBkYXRhOiBmb3JtRGF0YSxcbiAgICAgICAgICAgICAgICBoZWFkZXJzOiB7XG4gICAgICAgICAgICAgICAgICAgICdYLUNTUkYtVE9LRU4nOiB0b2tlbi52YWwoKVxuICAgICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICAgICAgcHJvY2Vzc0RhdGE6IGZhbHNlLFxuICAgICAgICAgICAgICAgIGNvbnRlbnRUeXBlOiBmYWxzZSxcbiAgICAgICAgICAgICAgICBzdWNjZXNzOiBmdW5jdGlvbigpIHtcbiAgICAgICAgICAgICAgICAgICAgY29uc29sZS5sb2coJ1VwbG9hZCBzdWNjZXNzJyk7XG4gICAgICAgICAgICAgICAgfSxcbiAgICAgICAgICAgICAgICBlcnJvcjogZnVuY3Rpb24oKSB7XG4gICAgICAgICAgICAgICAgICAgIGNvbnNvbGUubG9nKCdVcGxvYWQgZXJyb3InKTtcbiAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICB9KTtcblxuICAgICAgICB9KTtcbiAgICAgICAgZS5wcmV2ZW50RGVmYXVsdCgpO1xuICAgICAgICB3aW5kb3cuc2V0VGltZW91dChmdW5jdGlvbigpIHtcbiAgICAgICAgICAgIGxvY2F0aW9uLnJlbG9hZCgpO1xuICAgICAgICB9LCAyMDAwKVxuICAgIH0pO1xufSk7Il19
