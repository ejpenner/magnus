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

    // $('.opus-overlay').on('hover', function() {
    //     console.log('overlay trigger');
    //     $(this).fadeIn(300);
    // }, function() {
    //     $(this).fadeOut(300);
    // });

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
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIi4uLy4uLy5ucG0tbG9jYWwvZ2FsbGVyeS1hcHAvbm9kZV9tb2R1bGVzL2Jyb3dzZXItcGFjay9fcHJlbHVkZS5qcyIsInJlc291cmNlcy9hc3NldHMvanMvYXBwLmpzIl0sIm5hbWVzIjpbXSwibWFwcGluZ3MiOiJBQUFBO0FDQUE7O0FBQ0EsRUFBRSxRQUFGLEVBQVksS0FBWixDQUFrQixZQUFXOztBQUV6QixXQUFPLFVBQVAsQ0FBa0IsWUFBVztBQUN6QixVQUFFLGdCQUFGLEVBQW9CLE1BQXBCLENBQTJCLEdBQTNCLEVBQWdDLENBQWhDLEVBQW1DLE9BQW5DLENBQTJDLEdBQTNDLEVBQWdELFlBQVc7QUFDdkQsY0FBRSxJQUFGLEVBQVEsTUFBUjtBQUNILFNBRkQ7QUFHSCxLQUpELEVBSUcsSUFKSDs7QUFNQSxNQUFFLGlCQUFGLEVBQXFCLEVBQXJCLENBQXdCLFFBQXhCLEVBQWtDLFlBQVc7QUFDekMsZUFBTyxRQUFRLHVDQUFSLENBQVA7QUFDSCxLQUZEOztBQUlBLE1BQUUsVUFBRixFQUFjLEtBQWQsQ0FBb0IsWUFBVztBQUMzQixVQUFFLFdBQUYsRUFBZSxJQUFmLEdBQXNCLE1BQXRCO0FBQ0EsVUFBRSxJQUFGLEVBQVEsTUFBUjtBQUNILEtBSEQ7O0FBS0EsTUFBRSxXQUFGLEVBQWUsS0FBZixDQUFxQixZQUFXO0FBQzVCLFVBQUUsSUFBRixFQUFRLE1BQVI7QUFDQSxVQUFFLFVBQUYsRUFBYyxNQUFkO0FBQ0gsS0FIRDs7QUFNQSxNQUFFLE1BQUYsRUFBVSxNQUFWLENBQWlCLFlBQVc7QUFDeEIsWUFBSSxJQUFJLEVBQUUsSUFBRixFQUFRLFNBQVIsRUFBUjtBQUNBLFVBQUUsb0JBQUYsRUFBd0IsR0FBeEIsQ0FBNEIscUJBQTVCLEVBQW1ELFVBQVUsU0FBUyxDQUFDLENBQVYsQ0FBVixHQUF5QixJQUF6QixHQUFnQyxPQUFoQyxHQUEwQyxTQUFTLENBQUMsQ0FBVixDQUExQyxHQUF5RCxnQkFBNUc7QUFDSCxLQUhEOztBQUtBLFFBQUksUUFB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O0FBQ0g7QUFkRSxhQUFQO0FBaUJILFNBekJEO0FBMEJBLFVBQUUsY0FBRjtBQUNBLGVBQU8sVUFBUCxDQUFrQixZQUFXO0FBQ3pCLHFCQUFTLE1BQVQ7QUFDSCxTQUZELEVBRUcsSUFGSDtBQUdILEtBckNEO0FBc0NILENBbklEIiwiZmlsZSI6ImdlbmVyYXRlZC5qcyIsInNvdXJjZVJvb3QiOiIiLCJzb3VyY2VzQ29udGVudCI6WyIoZnVuY3Rpb24gZSh0LG4scil7ZnVuY3Rpb24gcyhvLHUpe2lmKCFuW29dKXtpZighdFtvXSl7dmFyIGE9dHlwZW9mIHJlcXVpcmU9PVwiZnVuY3Rpb25cIiYmcmVxdWlyZTtpZighdSYmYSlyZXR1cm4gYShvLCEwKTtpZihpKXJldHVybiBpKG8sITApO3ZhciBmPW5ldyBFcnJvcihcIkNhbm5vdCBmaW5kIG1vZHVsZSAnXCIrbytcIidcIik7dGhyb3cgZi5jb2RlPVwiTU9EVUxFX05PVF9GT1VORFwiLGZ9dmFyIGw9bltvXT17ZXhwb3J0czp7fX07dFtvXVswXS5jYWxsKGwuZXhwb3J0cyxmdW5jdGlvbihlKXt2YXIgbj10W29dWzFdW2VdO3JldHVybiBzKG4/bjplKX0sbCxsLmV4cG9ydHMsZSx0LG4scil9cmV0dXJuIG5bb10uZXhwb3J0c312YXIgaT10eXBlb2YgcmVxdWlyZT09XCJmdW5jdGlvblwiJiZyZXF1aXJlO2Zvcih2YXIgbz0wO288ci5sZW5ndGg7bysrKXMocltvXSk7cmV0dXJuIHN9KSIsIlwidXNlIHN0cmljdFwiO1xuJChkb2N1bWVudCkucmVhZHkoZnVuY3Rpb24oKSB7XG5cbiAgICB3aW5kb3cuc2V0VGltZW91dChmdW5jdGlvbigpIHtcbiAgICAgICAgJCgnLmFsZXJ0LXN1Y2Nlc3MnKS5mYWRlVG8oNTAwLCAwKS5zbGlkZVVwKDUwMCwgZnVuY3Rpb24oKSB7XG4gICAgICAgICAgICAkKHRoaXMpLnJlbW92ZSgpO1xuICAgICAgICB9KTtcbiAgICB9LCAzMDAwKTtcblxuICAgICQoJy5kZWxldGUtY29uZmlybScpLm9uKCdzdWJtaXQnLCBmdW5jdGlvbigpIHtcbiAgICAgICAgcmV0dXJuIGNvbmZpcm0oJ0FyZSB5b3Ugc3VyZSB5b3Ugd2FudCB0byBkZWxldGUgdGhpcz8nKTtcbiAgICB9KTtcblxuICAgICQoJyNwcmV2aWV3JykuY2xpY2soZnVuY3Rpb24oKSB7XG4gICAgICAgICQoJyNmdWxsdmlldycpLnNob3coKS51bnZlaWwoKTtcbiAgICAgICAgJCh0aGlzKS50b2dnbGUoKTtcbiAgICB9KTtcblxuICAgICQoJyNmdWxsdmlldycpLmNsaWNrKGZ1bmN0aW9uKCkge1xuICAgICAgICAkKHRoaXMpLnRvZ2dsZSgpO1xuICAgICAgICAkKCcjcHJldmlldycpLnRvZ2dsZSgpO1xuICAgIH0pO1xuXG5cbiAgICAkKHdpbmRvdykuc2Nyb2xsKGZ1bmN0aW9uKCkge1xuICAgICAgICB2YXIgeCA9ICQodGhpcykuc2Nyb2xsVG9wKCk7XG4gICAgICAgICQoJyNoZWFkZXItYmFja2dyb3VuZCcpLmNzcygnYmFja2dyb3VuZC1wb3NpdGlvbicsICcxMDAlICcgKyBwYXJzZUludCgteCkgKyAncHgnICsgJywgMCUgJyArIHBhcnNlSW50KC14KSArICdweCwgY2VudGVyIHRvcCcpO1xuICAgIH0pO1xuXG4gICAgdmFyIGltYWdlID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ2F2YXRhci1jcm9wcGVyJyk7XG5cbiAgICBmdW5jdGlvbiByZWFkVVJMKGlucHV0KSB7XG5cbiAgICAgICAgaWYgKGlucHV0LmZpbGVzICYmIGlucHV0LmZpbGVzWzBdKSB7XG4gICAgICAgICAgICBjb25zb2xlLmxvZygnUmVhZGluZyBmaWxlJyk7XG4gICAgICAgICAgICB2YXIgcmVhZGVyID0gbmV3IEZpbGVSZWFkZXIoKTtcblxuICAgICAgICAgICAgcmVhZGVyLnJlYWRBc0RhdGFVUkwoaW5wdXQuZmlsZXNbMF0pO1xuXG4gICAgICAgICAgICByZWFkZXIub25sb2FkID0gZnVuY3Rpb24oZSkge1xuICAgICAgICAgICAgICAgIGF2YXRhckNyb3BwZXIucmVwbGFjZShlLnRhcmdldC5yZXN1bHQpO1xuICAgICAgICAgICAgfTtcbiAgICAgICAgfVxuICAgIH1cblxuICAgIGZ1bmN0aW9uIHJlYWRGaWxlKGlucHV0LCBpbWdFbGVtZW50KSB7XG5cbiAgICAgICAgaWYgKGlucHV0LmZpbGVzICYmIGlucHV0LmZpbGVzWzBdKSB7XG4gICAgICAgICAgICBjb25zb2xlLmxvZygnUmVhZGluZyBmaWxlJyk7XG4gICAgICAgICAgICB2YXIgcmVhZGVyID0gbmV3IEZpbGVSZWFkZXIoKTtcblxuICAgICAgICAgICAgcmVhZGVyLnJlYWRBc0RhdGFVUkwoaW5wdXQuZmlsZXNbMF0pO1xuXG4gICAgICAgICAgICByZWFkZXIub25sb2FkID0gZnVuY3Rpb24oZSkge1xuICAgICAgICAgICAgICAgICQoaW1nRWxlbWVudCkuYXR0cignc3JjJywgZS50YXJnZXQucmVzdWx0KTtcbiAgICAgICAgICAgIH07XG4gICAgICAgIH1cbiAgICB9XG5cbiAgICAkKCcucmVwbHktdG9nZ2xlJykuY2xpY2soZnVuY3Rpb24oKSB7XG4gICAgICAgICQodGhpcykuY2hpbGRyZW4oKS5zaG93KCk7XG4gICAgICAgICQodGhpcykuY2hpbGRyZW4oJy5yZXBseS1idG4nKS5oaWRlKCk7XG4gICAgfSk7XG5cbiAgICAkKCcjYXZhdGFyLWZpbGUnKS5jaGFuZ2UoZnVuY3Rpb24oKSB7XG4gICAgICAgIHJlYWRVUkwodGhpcyk7XG4gICAgfSk7XG5cbiAgICAvLyAkKCcub3B1cy1vdmVybGF5Jykub24oJ2hvdmVyJywgZnVuY3Rpb24oKSB7XG4gICAgLy8gICAgIGNvbnNvbGUubG9nKCdvdmVybGF5IHRyaWdnZXInKTtcbiAgICAvLyAgICAgJCh0aGlzKS5mYWRlSW4oMzAwKTtcbiAgICAvLyB9LCBmdW5jdGlvbigpIHtcbiAgICAvLyAgICAgJCh0aGlzKS5mYWRlT3V0KDMwMCk7XG4gICAgLy8gfSk7XG5cbiAgICAkKCcjaW1hZ2UnKS5jaGFuZ2UoZnVuY3Rpb24oKSB7XG4gICAgICAgIHJlYWRGaWxlKHRoaXMsICcjcHJldmlldycpO1xuICAgICAgICByZWFkRmlsZSh0aGlzLCAnI3ByZXZpZXctZWRpdCcpO1xuICAgICAgICAkKCcjcHJldmlldycpLnNob3coKTtcbiAgICAgICAgJCgnZGl2LnByZXZpZXctY29udGFpbmVyJykuc2hvdygpO1xuICAgIH0pO1xuXG4gICAgdHJ5IHtcbiAgICAgICAgdmFyIGF2YXRhckNyb3BwZXIgPSBuZXcgQ3JvcHBlcihpbWFnZSwge1xuICAgICAgICAgICAgYXNwZWN0UmF0aW86IDEsXG4gICAgICAgICAgICBjcm9wOiBmdW5jdGlvbihlKSB7XG4gICAgICAgICAgICAgICAgLy8gY29uc29sZS5sb2coZS5kZXRhaWwueCk7XG4gICAgICAgICAgICAgICAgLy8gY29uc29sZS5sb2coZS5kZXRhaWwueSk7XG4gICAgICAgICAgICAgICAgLy8gY29uc29sZS5sb2coZS5kZXRhaWwud2lkdGgpO1xuICAgICAgICAgICAgICAgIC8vIGNvbnNvbGUubG9nKGUuZGV0YWlsLmhlaWdodCk7XG4gICAgICAgICAgICB9XG4gICAgICAgIH0pO1xuICAgIH0gY2F0Y2ggKGUpIHt9XG5cbiAgICAkKCcuY3JvcC1zdWJtaXQnKS5vbignY2xpY2snLCBmdW5jdGlvbihlKSB7XG4gICAgICAgIGNvbnNvbGUubG9nKCdDcm9wcGluZyBhdmF0YXInKTtcbiAgICAgICAgdmFyIGZvcm1PYmogPSAkKCcjYXZhdGFyLWZvcm0nKTtcbiAgICAgICAgdmFyIGZvcm1VUkwgPSBmb3JtT2JqLmF0dHIoXCJhY3Rpb25cIik7XG4gICAgICAgIHZhciB0b2tlbiA9ICQoJ2lucHV0W25hbWU9X3Rva2VuXScpO1xuXG4gICAgICAgIGNvbnNvbGUubG9nKGZvcm1VUkwpO1xuICAgICAgICBhdmF0YXJDcm9wcGVyLmdldENyb3BwZWRDYW52YXMoKS50b0Jsb2IoZnVuY3Rpb24oYmxvYikge1xuICAgICAgICAgICAgdmFyIGZvcm1EYXRhID0gbmV3IEZvcm1EYXRhKCk7XG5cblxuICAgICAgICAgICAgZm9ybURhdGEuYXBwZW5kKCdpbWFnZScsIGJsb2IpO1xuICAgICAgICAgICAgY29uc29sZS5sb2coZm9ybURhdGEpO1xuXG4gICAgICAgICAgICAvLyBVc2UgYGpRdWVyeS5hamF4YCBtZXRob2RcbiAgICAgICAgICAgICQuYWpheCh7XG4gICAgICAgICAgICAgICAgdXJsOiBmb3JtVVJMLFxuICAgICAgICAgICAgICAgIG1ldGhvZDogXCJQT1NUXCIsXG4gICAgICAgICAgICAgICAgZGF0YTogZm9ybURhdGEsXG4gICAgICAgICAgICAgICAgaGVhZGVyczoge1xuICAgICAgICAgICAgICAgICAgICAnWC1DU1JGLVRPS0VOJzogdG9rZW4udmFsKClcbiAgICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgICAgIHByb2Nlc3NEYXRhOiBmYWxzZSxcbiAgICAgICAgICAgICAgICBjb250ZW50VHlwZTogZmFsc2UsXG4gICAgICAgICAgICAgICAgc3VjY2VzczogZnVuY3Rpb24oKSB7XG4gICAgICAgICAgICAgICAgICAgIGNvbnNvbGUubG9nKCdVcGxvYWQgc3VjY2VzcycpO1xuICAgICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICAgICAgZXJyb3I6IGZ1bmN0aW9uKCkge1xuICAgICAgICAgICAgICAgICAgICBjb25zb2xlLmxvZygnVXBsb2FkIGVycm9yJyk7XG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgfSk7XG5cbiAgICAgICAgfSk7XG4gICAgICAgIGUucHJldmVudERlZmF1bHQoKTtcbiAgICAgICAgd2luZG93LnNldFRpbWVvdXQoZnVuY3Rpb24oKSB7XG4gICAgICAgICAgICBsb2NhdGlvbi5yZWxvYWQoKTtcbiAgICAgICAgfSwgMjAwMClcbiAgICB9KTtcbn0pOyJdfQ==
