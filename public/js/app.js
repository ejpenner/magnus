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
            // console.log(e.detail.x);
            // console.log(e.detail.y);
            // console.log(e.detail.width);
            // console.log(e.detail.height);
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
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIi4uLy4uLy5ucG0tbG9jYWwvZ2FsbGVyeS1hcHAvbm9kZV9tb2R1bGVzL2Jyb3dzZXJpZnkvbm9kZV9tb2R1bGVzL2Jyb3dzZXItcGFjay9fcHJlbHVkZS5qcyIsInJlc291cmNlcy9hc3NldHMvanMvYXBwLmpzIl0sIm5hbWVzIjpbXSwibWFwcGluZ3MiOiJBQUFBO0FDQUE7O0FBQ0EsRUFBRSxRQUFGLEVBQVksS0FBWixDQUFrQixZQUFXOztBQUV6QixNQUFFLGdCQUFGLEVBQW9CLFNBQXBCLENBQThCLEdBQTlCOztBQUVBLFdBQU8sVUFBUCxDQUFrQixZQUFXO0FBQ3pCLFVBQUUsZ0JBQUYsRUFBb0IsTUFBcEIsQ0FBMkIsR0FBM0IsRUFBZ0MsQ0FBaEMsRUFBbUMsT0FBbkMsQ0FBMkMsR0FBM0MsRUFBZ0QsWUFBVztBQUN2RCxjQUFFLElBQUYsRUFBUSxNQUFSO0FBQ0gsU0FGRDtBQUdILEtBSkQsRUFJRyxJQUpIOztBQU1BLE1BQUUsaUJBQUYsRUFBcUIsRUFBckIsQ0FBd0IsUUFBeEIsRUFBa0MsWUFBVztBQUN6QyxlQUFPLFFBQVEsdUNBQVIsQ0FBUDtBQUNILEtBRkQ7O0FBSUEsTUFBRSxVQUFGLEVBQWMsS0FBZCxDQUFvQixZQUFXO0FBQzNCLFVBQUUsV0FBRixFQUFlLElBQWYsR0FBc0IsTUFBdEI7QUFDQSxVQUFFLElBQUYsRUFBUSxNQUFSO0FBQ0gsS0FIRDs7QUFLQSxNQUFFLFdBQUYsRUFBZSxLQUFmLENBQXFCLFlBQVc7QUFDNUIsVUFBRSxJQUFGLEVBQVEsTUFBUjtBQUNBLFVBQUUsVUFBRixFQUFjLE1BQWQ7QUFDSCxLQUhEOztBQU1BLE1BQUUsTUFBRixFQUFVLE1BQVYsQ0FBaUIsWUFBVztBQUN4QixZQUFJLElBQUksRUFBRSxJQUFGLEVBQVEsU0FBUixFQUFSO0FBQ0EsVUFBRSxvQkFBRixFQUF3QixHQUF4QixDQUE0QixxQkFBNUIsRUFBbUQsVUFBVSxTQUFTLENBQUMsQ0FBVixDQUFWLEdBQXlCLElBQXpCLEdBQWdDLE9BQWhD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QVIsQ0FBWSxjQUFaO0FBQ0g7QUFkRSxhQUFQO0FBaUJILFNBekJEO0FBMEJBLFVBQUUsY0FBRjtBQUNBLGVBQU8sVUFBUCxDQUFrQixZQUFXO0FBQ3pCLHFCQUFTLE1BQVQ7QUFDSCxTQUZELEVBRUcsSUFGSDtBQUdILEtBckNEO0FBc0NILENBNUhEIiwiZmlsZSI6ImdlbmVyYXRlZC5qcyIsInNvdXJjZVJvb3QiOiIiLCJzb3VyY2VzQ29udGVudCI6WyIoZnVuY3Rpb24gZSh0LG4scil7ZnVuY3Rpb24gcyhvLHUpe2lmKCFuW29dKXtpZighdFtvXSl7dmFyIGE9dHlwZW9mIHJlcXVpcmU9PVwiZnVuY3Rpb25cIiYmcmVxdWlyZTtpZighdSYmYSlyZXR1cm4gYShvLCEwKTtpZihpKXJldHVybiBpKG8sITApO3ZhciBmPW5ldyBFcnJvcihcIkNhbm5vdCBmaW5kIG1vZHVsZSAnXCIrbytcIidcIik7dGhyb3cgZi5jb2RlPVwiTU9EVUxFX05PVF9GT1VORFwiLGZ9dmFyIGw9bltvXT17ZXhwb3J0czp7fX07dFtvXVswXS5jYWxsKGwuZXhwb3J0cyxmdW5jdGlvbihlKXt2YXIgbj10W29dWzFdW2VdO3JldHVybiBzKG4/bjplKX0sbCxsLmV4cG9ydHMsZSx0LG4scil9cmV0dXJuIG5bb10uZXhwb3J0c312YXIgaT10eXBlb2YgcmVxdWlyZT09XCJmdW5jdGlvblwiJiZyZXF1aXJlO2Zvcih2YXIgbz0wO288ci5sZW5ndGg7bysrKXMocltvXSk7cmV0dXJuIHN9KSIsIlwidXNlIHN0cmljdFwiO1xuJChkb2N1bWVudCkucmVhZHkoZnVuY3Rpb24oKSB7XG5cbiAgICAkKFwiLmFsZXJ0LXN1Y2Nlc3NcIikuc2xpZGVEb3duKDQwMCk7XG5cbiAgICB3aW5kb3cuc2V0VGltZW91dChmdW5jdGlvbigpIHtcbiAgICAgICAgJChcIi5hbGVydC1zdWNjZXNzXCIpLmZhZGVUbyg1MDAsIDApLnNsaWRlVXAoNTAwLCBmdW5jdGlvbigpIHtcbiAgICAgICAgICAgICQodGhpcykucmVtb3ZlKCk7XG4gICAgICAgIH0pO1xuICAgIH0sIDMwMDApO1xuXG4gICAgJCgnLmRlbGV0ZS1jb25maXJtJykub24oJ3N1Ym1pdCcsIGZ1bmN0aW9uKCkge1xuICAgICAgICByZXR1cm4gY29uZmlybSgnQXJlIHlvdSBzdXJlIHlvdSB3YW50IHRvIGRlbGV0ZSB0aGlzPycpO1xuICAgIH0pO1xuXG4gICAgJCgnI3ByZXZpZXcnKS5jbGljayhmdW5jdGlvbigpIHtcbiAgICAgICAgJCgnI2Z1bGx2aWV3Jykuc2hvdygpLnVudmVpbCgpO1xuICAgICAgICAkKHRoaXMpLnRvZ2dsZSgpO1xuICAgIH0pO1xuXG4gICAgJCgnI2Z1bGx2aWV3JykuY2xpY2soZnVuY3Rpb24oKSB7XG4gICAgICAgICQodGhpcykudG9nZ2xlKCk7XG4gICAgICAgICQoJyNwcmV2aWV3JykudG9nZ2xlKCk7XG4gICAgfSk7XG5cblxuICAgICQod2luZG93KS5zY3JvbGwoZnVuY3Rpb24oKSB7XG4gICAgICAgIHZhciB4ID0gJCh0aGlzKS5zY3JvbGxUb3AoKTtcbiAgICAgICAgJCgnI2hlYWRlci1iYWNrZ3JvdW5kJykuY3NzKCdiYWNrZ3JvdW5kLXBvc2l0aW9uJywgJzEwMCUgJyArIHBhcnNlSW50KC14KSArICdweCcgKyAnLCAwJSAnICsgcGFyc2VJbnQoLXgpICsgJ3B4LCBjZW50ZXIgdG9wJyk7XG4gICAgfSk7XG5cbiAgICB2YXIgaW1hZ2UgPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgnYXZhdGFyLWNyb3BwZXInKTtcblxuICAgIGZ1bmN0aW9uIHJlYWRVUkwoaW5wdXQpIHtcblxuICAgICAgICBpZiAoaW5wdXQuZmlsZXMgJiYgaW5wdXQuZmlsZXNbMF0pIHtcbiAgICAgICAgICAgIGNvbnNvbGUubG9nKCdSZWFkaW5nIGZpbGUnKTtcbiAgICAgICAgICAgIHZhciByZWFkZXIgPSBuZXcgRmlsZVJlYWRlcigpO1xuXG4gICAgICAgICAgICByZWFkZXIucmVhZEFzRGF0YVVSTChpbnB1dC5maWxlc1swXSk7XG5cbiAgICAgICAgICAgIHJlYWRlci5vbmxvYWQgPSBmdW5jdGlvbihlKSB7XG4gICAgICAgICAgICAgICAgYXZhdGFyQ3JvcHBlci5yZXBsYWNlKGUudGFyZ2V0LnJlc3VsdCk7XG4gICAgICAgICAgICB9O1xuICAgICAgICB9XG4gICAgfVxuXG4gICAgZnVuY3Rpb24gcmVhZEZpbGUoaW5wdXQsIGltZ0VsZW1lbnQpIHtcblxuICAgICAgICBpZiAoaW5wdXQuZmlsZXMgJiYgaW5wdXQuZmlsZXNbMF0pIHtcbiAgICAgICAgICAgIGNvbnNvbGUubG9nKCdSZWFkaW5nIGZpbGUnKTtcbiAgICAgICAgICAgIHZhciByZWFkZXIgPSBuZXcgRmlsZVJlYWRlcigpO1xuXG4gICAgICAgICAgICByZWFkZXIucmVhZEFzRGF0YVVSTChpbnB1dC5maWxlc1swXSk7XG5cbiAgICAgICAgICAgIHJlYWRlci5vbmxvYWQgPSBmdW5jdGlvbihlKSB7XG4gICAgICAgICAgICAgICAgJChpbWdFbGVtZW50KS5hdHRyKCdzcmMnLCBlLnRhcmdldC5yZXN1bHQpO1xuICAgICAgICAgICAgfTtcbiAgICAgICAgfVxuICAgIH1cblxuICAgICQoXCIucmVwbHktdG9nZ2xlXCIpLmNsaWNrKGZ1bmN0aW9uKCkge1xuICAgICAgICAkKHRoaXMpLmNoaWxkcmVuKCkuc2hvdygpO1xuICAgICAgICAkKHRoaXMpLmNoaWxkcmVuKCcucmVwbHktYnRuJykuaGlkZSgpO1xuICAgIH0pO1xuXG4gICAgJCgnI2F2YXRhci1maWxlJykuY2hhbmdlKGZ1bmN0aW9uKCkge1xuICAgICAgICByZWFkVVJMKHRoaXMpO1xuICAgIH0pO1xuXG4gICAgJCgnI2ltYWdlJykuY2hhbmdlKGZ1bmN0aW9uKCkge1xuICAgICAgICByZWFkRmlsZSh0aGlzLCAnI3ByZXZpZXcnKTtcbiAgICAgICAgcmVhZEZpbGUodGhpcywgJyNwcmV2aWV3LWVkaXQnKTtcbiAgICAgICAgJCgnI3ByZXZpZXcnKS5zaG93KCk7XG4gICAgICAgICQoJ2Rpdi5wcmV2aWV3LWNvbnRhaW5lcicpLnNob3coKTtcbiAgICB9KTtcblxuICAgIHZhciBhdmF0YXJDcm9wcGVyID0gbmV3IENyb3BwZXIoaW1hZ2UsIHtcbiAgICAgICAgYXNwZWN0UmF0aW86IDEsXG4gICAgICAgIGNyb3A6IGZ1bmN0aW9uKGUpIHtcbiAgICAgICAgICAgIC8vIGNvbnNvbGUubG9nKGUuZGV0YWlsLngpO1xuICAgICAgICAgICAgLy8gY29uc29sZS5sb2coZS5kZXRhaWwueSk7XG4gICAgICAgICAgICAvLyBjb25zb2xlLmxvZyhlLmRldGFpbC53aWR0aCk7XG4gICAgICAgICAgICAvLyBjb25zb2xlLmxvZyhlLmRldGFpbC5oZWlnaHQpO1xuICAgICAgICB9XG4gICAgfSk7XG5cbiAgICAkKCcuY3JvcC1zdWJtaXQnKS5vbignY2xpY2snLCBmdW5jdGlvbihlKSB7XG4gICAgICAgIGNvbnNvbGUubG9nKCdDcm9wcGluZyBhdmF0YXInKTtcbiAgICAgICAgdmFyIGZvcm1PYmogPSAkKCcjYXZhdGFyLWZvcm0nKTtcbiAgICAgICAgdmFyIGZvcm1VUkwgPSBmb3JtT2JqLmF0dHIoXCJhY3Rpb25cIik7XG4gICAgICAgIHZhciB0b2tlbiA9ICQoJ2lucHV0W25hbWU9X3Rva2VuXScpO1xuXG4gICAgICAgIGNvbnNvbGUubG9nKGZvcm1VUkwpO1xuICAgICAgICBhdmF0YXJDcm9wcGVyLmdldENyb3BwZWRDYW52YXMoKS50b0Jsb2IoZnVuY3Rpb24oYmxvYikge1xuICAgICAgICAgICAgdmFyIGZvcm1EYXRhID0gbmV3IEZvcm1EYXRhKCk7XG5cblxuICAgICAgICAgICAgZm9ybURhdGEuYXBwZW5kKCdpbWFnZScsIGJsb2IpO1xuICAgICAgICAgICAgY29uc29sZS5sb2coZm9ybURhdGEpO1xuXG4gICAgICAgICAgICAvLyBVc2UgYGpRdWVyeS5hamF4YCBtZXRob2RcbiAgICAgICAgICAgICQuYWpheCh7XG4gICAgICAgICAgICAgICAgdXJsOiBmb3JtVVJMLFxuICAgICAgICAgICAgICAgIG1ldGhvZDogXCJQT1NUXCIsXG4gICAgICAgICAgICAgICAgZGF0YTogZm9ybURhdGEsXG4gICAgICAgICAgICAgICAgaGVhZGVyczoge1xuICAgICAgICAgICAgICAgICAgICAnWC1DU1JGLVRPS0VOJzogdG9rZW4udmFsKClcbiAgICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgICAgIHByb2Nlc3NEYXRhOiBmYWxzZSxcbiAgICAgICAgICAgICAgICBjb250ZW50VHlwZTogZmFsc2UsXG4gICAgICAgICAgICAgICAgc3VjY2VzczogZnVuY3Rpb24oKSB7XG4gICAgICAgICAgICAgICAgICAgIGNvbnNvbGUubG9nKCdVcGxvYWQgc3VjY2VzcycpO1xuICAgICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICAgICAgZXJyb3I6IGZ1bmN0aW9uKCkge1xuICAgICAgICAgICAgICAgICAgICBjb25zb2xlLmxvZygnVXBsb2FkIGVycm9yJyk7XG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgfSk7XG5cbiAgICAgICAgfSk7XG4gICAgICAgIGUucHJldmVudERlZmF1bHQoKTtcbiAgICAgICAgd2luZG93LnNldFRpbWVvdXQoZnVuY3Rpb24oKSB7XG4gICAgICAgICAgICBsb2NhdGlvbi5yZWxvYWQoKTtcbiAgICAgICAgfSwgMjAwMClcbiAgICB9KTtcbn0pOyJdfQ==
