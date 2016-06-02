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

    $('#avatar-file').change(function () {

        readURL(this);
    });

    var cropper = new Cropper(image, {
        aspectRatio: 1 / 1,
        crop: function (e) {
            console.log(e.detail.x);
            console.log(e.detail.y);
            console.log(e.detail.width);
            console.log(e.detail.height);
            // console.log(e.detail.rotate);
            // console.log(e.detail.scaleX);
            // console.log(e.detail.scaleY);
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
                url: '/users/avatar',
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
    });
});

},{}]},{},[1])
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIi4uLy4uLy5ucG0tbG9jYWwvZ2FsbGVyeS1hcHAvbm9kZV9tb2R1bGVzL2Jyb3dzZXJpZnkvbm9kZV9tb2R1bGVzL2Jyb3dzZXItcGFjay9fcHJlbHVkZS5qcyIsInJlc291cmNlcy9hc3NldHMvanMvYXBwLmpzIl0sIm5hbWVzIjpbXSwibWFwcGluZ3MiOiJBQUFBO0FDQUE7O0FBQ0EsRUFBRSxRQUFGLEVBQVksS0FBWixDQUFrQixZQUFXOztBQUV6QixXQUFPLFVBQVAsQ0FBa0IsWUFBVztBQUN6QixVQUFFLGdCQUFGLEVBQW9CLE1BQXBCLENBQTJCLEdBQTNCLEVBQWdDLENBQWhDLEVBQW1DLE9BQW5DLENBQTJDLEdBQTNDLEVBQWdELFlBQVc7QUFDdkQsY0FBRSxJQUFGLEVBQVEsTUFBUjtBQUNILFNBRkQ7QUFHSCxLQUpELEVBSUcsSUFKSDs7QUFNQSxNQUFFLGlCQUFGLEVBQXFCLEVBQXJCLENBQXdCLFFBQXhCLEVBQWtDLFlBQVc7QUFDekMsZUFBTyxRQUFRLHVDQUFSLENBQVA7QUFDSCxLQUZEOztBQUlBLE1BQUUsTUFBRixFQUFVLE1BQVYsQ0FBaUIsWUFBVztBQUN4QixZQUFJLElBQUksRUFBRSxJQUFGLEVBQVEsU0FBUixFQUFSO0FBQ0EsVUFBRSxvQkFBRixFQUF3QixHQUF4QixDQUE0QixxQkFBNUIsRUFBbUQsVUFBVSxTQUFTLENBQUMsQ0FBVixDQUFWLEdBQXlCLElBQXpCLEdBQWdDLE9BQWhDLEdBQTBDLFNBQVMsQ0FBQyxDQUFWLENBQTFDLEdBQXlELGdCQUE1RztBQUNILEtBSEQ7O0FBS0EsUUFBSSxRQUFRLFNBQVMsY0FBVCxDQUF3QixnQkFBeEIsQ0FBWjs7QUFFQSxhQUFTLE9BQVQsQ0FBaUIsS0FBakIsRUFBd0I7O0FBRXBCLFlBQUksTUFBTSxLQUFOLElBQWUsTUFBTSxLQUFOLENBQVksQ0FBWixDQUFuQixFQUFtQztBQUMvQixvQkFBUSxHQUFSLENBQVksY0FBWjtBQUNBLGdCQUFJLFNBQVMsSUFBSSxVQUFKLEVBQWI7O0FBRUEsbUJBQU8sYUFBUCxDQUFxQixNQUFNLEtBQU4sQ0FBWSxDQUFaLENBQXJCOztBQUVBLG1CQUFPLE1BQVAsR0FBZ0IsVUFBUyxDQUFULEVBQVk7QUFDeEIsd0JBQVEsT0FBUixDQUFnQixFQUFFLE1BQUYsQ0FBUyxNQUF6QjtBQUNILGFBRkQ7QUFHSDtBQUNKOztBQUVELE1BQUUsY0FBRixFQUFrQixNQUFsQixDQUF5QixZQUFXOztBQUVoQyxnQkFBUSxJQUFSO0FBRUgsS0FKRDs7QUFNQSxRQUFJLFVBQVUsSUFBSSxPQUFKLENBQVksS0FBWixFQUFtQjtBQUM3QixxQkFBYSxJQUFJLENBRFk7QUFFN0IsY0FBTSxVQUFTLENBQVQsRUFBWTtBQUNkLG9CQUFRLEdBQVIsQ0FBWSxFQUFFLE1BQUYsQ0FBUyxDQUFyQjtBQUNBLG9CQUFRLEdBQVIsQ0FBWSxFQUFFLE1BQUYsQ0FBUyxDQUFyQjtBQUNBLG9CQUFRLEdBQVIsQ0FBWSxFQUFFLE1BQUYsQ0FBUyxLQUFyQjtBQUNBLG9CQUFRLEdBQVIsQ0FBWSxFQUFFLE1BQUYsQ0FBUyxNQUFyQjs7OztBQUlIO0FBVjRCLEtBQW5CLENBQWQ7O0FBYUEsTUFBRSxjQUFGLEVBQWtCLEVBQWxCLENBQXFCLE9BQXJCLEVBQThCLFVBQVMsQ0FBVCxFQUFZO0FBQ3RDLGdCQUFRLEdBQVIsQ0FBWSxpQkFBWjtBQUNBLFlBQUksVUFBVSxFQUFFLGNBQUYsQ0FBZDtBQUNBLFlBQUksVUFBVSxRQUFRLElBQVIsQ0FBYSxRQUFiLENBQWQ7QUFDQSxZQUFJLFFBQVEsRUFBRSxvQkFBRixDQUFaOztBQUVBLGdCQUFRLEdBQVIsQ0FBWSxPQUFaO0FBQ0EsZ0JBQVEsZ0JBQVIsR0FBMkIsTUFBM0IsQ0FBa0MsVUFBUyxJQUFULEVBQWU7QUFDN0MsZ0JBQUksV0FBVyxJQUFJLFFBQUosRUFBZjs7QUFHQSxxQkFBUyxNQUFULENBQWdCLE9BQWhCLEVBQXlCLElBQXpCO0FBQ0Esb0JBQVEsR0FBUixDQUFZLFFBQVo7OztBQUdBLGNBQUUsSUFBRixDQUFPO0FBQ0gscUJBQUssZUFERjtBQUVILHdCQUFRLE1BRkw7QUFHSCxzQkFBTSxRQUhIO0FBSUgseUJBQVM7QUFDTCxvQ0FBZ0IsTUFBTSxHQUFOO0FBRFgsaUJBSk47QUFPSCw2QkFBYSxLQVBWO0FBUUgsNkJBQWEsS0FSVjtBQVNILHlCQUFTLFlBQVc7QUFDaEIsNEJBQVEsR0FBUixDQUFZLGdCQUFaO0FBQ0gsaUJBWEU7QUFZSCx1QkFBTyxZQUFXO0FBQ2QsNEJBQVEsR0FBUixDQUFZLGNBQVo7QUFDSDtBQWRFLGFBQVA7QUFrQkgsU0ExQkQ7QUEyQkEsVUFBRSxjQUFGO0FBQ0gsS0FuQ0Q7QUFxQ0gsQ0F6RkQiLCJmaWxlIjoiZ2VuZXJhdGVkLmpzIiwic291cmNlUm9vdCI6IiIsInNvdXJjZXNDb250ZW50IjpbIihmdW5jdGlvbiBlKHQsbixyKXtmdW5jdGlvbiBzKG8sdSl7aWYoIW5bb10pe2lmKCF0W29dKXt2YXIgYT10eXBlb2YgcmVxdWlyZT09XCJmdW5jdGlvblwiJiZyZXF1aXJlO2lmKCF1JiZhKXJldHVybiBhKG8sITApO2lmKGkpcmV0dXJuIGkobywhMCk7dmFyIGY9bmV3IEVycm9yKFwiQ2Fubm90IGZpbmQgbW9kdWxlICdcIitvK1wiJ1wiKTt0aHJvdyBmLmNvZGU9XCJNT0RVTEVfTk9UX0ZPVU5EXCIsZn12YXIgbD1uW29dPXtleHBvcnRzOnt9fTt0W29dWzBdLmNhbGwobC5leHBvcnRzLGZ1bmN0aW9uKGUpe3ZhciBuPXRbb11bMV1bZV07cmV0dXJuIHMobj9uOmUpfSxsLGwuZXhwb3J0cyxlLHQsbixyKX1yZXR1cm4gbltvXS5leHBvcnRzfXZhciBpPXR5cGVvZiByZXF1aXJlPT1cImZ1bmN0aW9uXCImJnJlcXVpcmU7Zm9yKHZhciBvPTA7bzxyLmxlbmd0aDtvKyspcyhyW29dKTtyZXR1cm4gc30pIiwiXCJ1c2Ugc3RyaWN0XCI7XG4kKGRvY3VtZW50KS5yZWFkeShmdW5jdGlvbigpIHtcblxuICAgIHdpbmRvdy5zZXRUaW1lb3V0KGZ1bmN0aW9uKCkge1xuICAgICAgICAkKFwiLmFsZXJ0LXN1Y2Nlc3NcIikuZmFkZVRvKDUwMCwgMCkuc2xpZGVVcCg1MDAsIGZ1bmN0aW9uKCkge1xuICAgICAgICAgICAgJCh0aGlzKS5yZW1vdmUoKTtcbiAgICAgICAgfSk7XG4gICAgfSwgMzAwMCk7XG5cbiAgICAkKCcuZGVsZXRlLWNvbmZpcm0nKS5vbignc3VibWl0JywgZnVuY3Rpb24oKSB7XG4gICAgICAgIHJldHVybiBjb25maXJtKCdBcmUgeW91IHN1cmUgeW91IHdhbnQgdG8gZGVsZXRlIHRoaXM/Jyk7XG4gICAgfSk7XG5cbiAgICAkKHdpbmRvdykuc2Nyb2xsKGZ1bmN0aW9uKCkge1xuICAgICAgICB2YXIgeCA9ICQodGhpcykuc2Nyb2xsVG9wKCk7XG4gICAgICAgICQoJyNoZWFkZXItYmFja2dyb3VuZCcpLmNzcygnYmFja2dyb3VuZC1wb3NpdGlvbicsICcxMDAlICcgKyBwYXJzZUludCgteCkgKyAncHgnICsgJywgMCUgJyArIHBhcnNlSW50KC14KSArICdweCwgY2VudGVyIHRvcCcpO1xuICAgIH0pO1xuXG4gICAgdmFyIGltYWdlID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ2F2YXRhci1jcm9wcGVyJyk7XG5cbiAgICBmdW5jdGlvbiByZWFkVVJMKGlucHV0KSB7XG5cbiAgICAgICAgaWYgKGlucHV0LmZpbGVzICYmIGlucHV0LmZpbGVzWzBdKSB7XG4gICAgICAgICAgICBjb25zb2xlLmxvZygnUmVhZGluZyBmaWxlJyk7XG4gICAgICAgICAgICB2YXIgcmVhZGVyID0gbmV3IEZpbGVSZWFkZXIoKTtcblxuICAgICAgICAgICAgcmVhZGVyLnJlYWRBc0RhdGFVUkwoaW5wdXQuZmlsZXNbMF0pO1xuXG4gICAgICAgICAgICByZWFkZXIub25sb2FkID0gZnVuY3Rpb24oZSkge1xuICAgICAgICAgICAgICAgIGNyb3BwZXIucmVwbGFjZShlLnRhcmdldC5yZXN1bHQpO1xuICAgICAgICAgICAgfTtcbiAgICAgICAgfVxuICAgIH1cblxuICAgICQoJyNhdmF0YXItZmlsZScpLmNoYW5nZShmdW5jdGlvbigpIHtcblxuICAgICAgICByZWFkVVJMKHRoaXMpO1xuXG4gICAgfSk7XG5cbiAgICB2YXIgY3JvcHBlciA9IG5ldyBDcm9wcGVyKGltYWdlLCB7XG4gICAgICAgIGFzcGVjdFJhdGlvOiAxIC8gMSxcbiAgICAgICAgY3JvcDogZnVuY3Rpb24oZSkge1xuICAgICAgICAgICAgY29uc29sZS5sb2coZS5kZXRhaWwueCk7XG4gICAgICAgICAgICBjb25zb2xlLmxvZyhlLmRldGFpbC55KTtcbiAgICAgICAgICAgIGNvbnNvbGUubG9nKGUuZGV0YWlsLndpZHRoKTtcbiAgICAgICAgICAgIGNvbnNvbGUubG9nKGUuZGV0YWlsLmhlaWdodCk7XG4gICAgICAgICAgICAvLyBjb25zb2xlLmxvZyhlLmRldGFpbC5yb3RhdGUpO1xuICAgICAgICAgICAgLy8gY29uc29sZS5sb2coZS5kZXRhaWwuc2NhbGVYKTtcbiAgICAgICAgICAgIC8vIGNvbnNvbGUubG9nKGUuZGV0YWlsLnNjYWxlWSk7XG4gICAgICAgIH1cbiAgICB9KTtcblxuICAgICQoJy5jcm9wLXN1Ym1pdCcpLm9uKCdjbGljaycsIGZ1bmN0aW9uKGUpIHtcbiAgICAgICAgY29uc29sZS5sb2coJ0Nyb3BwaW5nIGF2YXRhcicpO1xuICAgICAgICB2YXIgZm9ybU9iaiA9ICQoJyNhdmF0YXItZm9ybScpO1xuICAgICAgICB2YXIgZm9ybVVSTCA9IGZvcm1PYmouYXR0cihcImFjdGlvblwiKTtcbiAgICAgICAgdmFyIHRva2VuID0gJCgnaW5wdXRbbmFtZT1fdG9rZW5dJyk7XG5cbiAgICAgICAgY29uc29sZS5sb2coZm9ybVVSTCk7XG4gICAgICAgIGNyb3BwZXIuZ2V0Q3JvcHBlZENhbnZhcygpLnRvQmxvYihmdW5jdGlvbihibG9iKSB7XG4gICAgICAgICAgICB2YXIgZm9ybURhdGEgPSBuZXcgRm9ybURhdGEoKTtcblxuXG4gICAgICAgICAgICBmb3JtRGF0YS5hcHBlbmQoJ2ltYWdlJywgYmxvYik7XG4gICAgICAgICAgICBjb25zb2xlLmxvZyhmb3JtRGF0YSk7XG5cbiAgICAgICAgICAgIC8vIFVzZSBgalF1ZXJ5LmFqYXhgIG1ldGhvZFxuICAgICAgICAgICAgJC5hamF4KHtcbiAgICAgICAgICAgICAgICB1cmw6ICcvdXNlcnMvYXZhdGFyJyxcbiAgICAgICAgICAgICAgICBtZXRob2Q6IFwiUE9TVFwiLFxuICAgICAgICAgICAgICAgIGRhdGE6IGZvcm1EYXRhLFxuICAgICAgICAgICAgICAgIGhlYWRlcnM6IHtcbiAgICAgICAgICAgICAgICAgICAgJ1gtQ1NSRi1UT0tFTic6IHRva2VuLnZhbCgpXG4gICAgICAgICAgICAgICAgfSxcbiAgICAgICAgICAgICAgICBwcm9jZXNzRGF0YTogZmFsc2UsXG4gICAgICAgICAgICAgICAgY29udGVudFR5cGU6IGZhbHNlLFxuICAgICAgICAgICAgICAgIHN1Y2Nlc3M6IGZ1bmN0aW9uKCkge1xuICAgICAgICAgICAgICAgICAgICBjb25zb2xlLmxvZygnVXBsb2FkIHN1Y2Nlc3MnKTtcbiAgICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgICAgIGVycm9yOiBmdW5jdGlvbigpIHtcbiAgICAgICAgICAgICAgICAgICAgY29uc29sZS5sb2coJ1VwbG9hZCBlcnJvcicpO1xuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgIH0pO1xuXG5cbiAgICAgICAgfSk7XG4gICAgICAgIGUucHJldmVudERlZmF1bHQoKTtcbiAgICB9KTtcblxufSk7Il19
