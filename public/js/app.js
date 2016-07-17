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

    $(".opus-src").unveil();

    $('#preview').click(function () {
        $('#fullview').show().unveil();
        $('.fullview-box').show();
        $(this).toggle();
    });

    $('#fullview').click(function () {
        $(this).toggle();
        $('.fullview-box').toggle();
        $('#preview').toggle();
    });

    $('#selectAllOpus').click(function () {
        var checkbox = $('.opus-message-select');
        checkbox.prop('checked', !checkbox.is(":checked"));
    });

    //var num = 150; //number of pixels before modifying styles
    var navpos = $('.top-header').offset();

    $(window).bind('scroll', function () {

        var x = $(this).scrollTop();
        $('#header-background').css('background-position', '100% ' + parseInt(-x) + 'px' + ', 0% ' + parseInt(-x) + 'px, center top');

        if ($(window).scrollTop() > navpos.top) {
            $('.top-header').addClass('fixed');
        } else {
            $('.top-header').removeClass('fixed');
        }
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
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIi4uLy4uLy5ucG0tbG9jYWwvZ2FsbGVyeS1hcHAvbm9kZV9tb2R1bGVzL2Jyb3dzZXItcGFjay9fcHJlbHVkZS5qcyIsInJlc291cmNlcy9hc3NldHMvanMvYXBwLmpzIl0sIm5hbWVzIjpbXSwibWFwcGluZ3MiOiJBQUFBO0FDQUE7O0FBQ0EsRUFBRSxRQUFGLEVBQVksS0FBWixDQUFrQixZQUFXOztBQUV6QixXQUFPLFVBQVAsQ0FBa0IsWUFBVztBQUN6QixVQUFFLGdCQUFGLEVBQW9CLE1BQXBCLENBQTJCLEdBQTNCLEVBQWdDLENBQWhDLEVBQW1DLE9BQW5DLENBQTJDLEdBQTNDLEVBQWdELFlBQVc7QUFDdkQsY0FBRSxJQUFGLEVBQVEsTUFBUjtBQUNILFNBRkQ7QUFHSCxLQUpELEVBSUcsSUFKSDs7QUFNQSxNQUFFLGlCQUFGLEVBQXFCLEVBQXJCLENBQXdCLFFBQXhCLEVBQWtDLFlBQVc7QUFDekMsZUFBTyxRQUFRLHVDQUFSLENBQVA7QUFDSCxLQUZEOztBQUlBLE1BQUUsV0FBRixFQUFlLE1BQWY7O0FBRUEsTUFBRSxVQUFGLEVBQWMsS0FBZCxDQUFvQixZQUFXO0FBQzNCLFVBQUUsV0FBRixFQUFlLElBQWYsR0FBc0IsTUFBdEI7QUFDQSxVQUFFLGVBQUYsRUFBbUIsSUFBbkI7QUFDQSxVQUFFLElBQUYsRUFBUSxNQUFSO0FBQ0gsS0FKRDs7QUFNQSxNQUFFLFdBQUYsRUFBZSxLQUFmLENBQXFCLFlBQVc7QUFDNUIsVUFBRSxJQUFGLEVBQVEsTUFBUjtBQUNBLFVBQUUsZUFBRixFQUFtQixNQUFuQjtBQUNBLFVBQUUsVUFBRixFQUFjLE1BQWQ7QUFDSCxLQUpEOztBQU1BLE1BQUUsZ0JBQUYsRUFBb0IsS0FBcEIsQ0FBMEIsWUFBVztBQUNqQyxZQUFJLFdBQVcsRUFBRSxzQkFBRixDQUFmO0FBQ0EsaUJBQVMsSUFBVCxDQUFjLFNBQWQsRUFBeUIsQ0FBQyxTQUFTLEVBQVQsQ0FBWSxVQUFaLENBQTFCO0FBQ0gsS0FIRDs7O0FBT0EsUUFBSSxTQUFTLEVBQUUsYUFBRixFQUFpQixNQUFqQixFQUFiOztBQUVBLE1BQUUsTUFBRixFQUFVLElBQVYsQ0FBZSxRQUFmLEVBQXlCLFlBQVc7O0FBRWhDLFlBQUksSUFBSSxFQUFFLElBQUYsRUFBUSxTQUFSLEVBQVI7QUFDQSxVQUFFLG9CQUFGLEVBQXdCLEdBQXhCLENBQTRCLHFCQUE1QixFQUFtRCxVQUFVLFNBQVMsQ0FBQyxDQUFWLENBQVYsR0FBeUIsSUFBekIsR0FBZ0MsT0FBaEMsR0FBMEMsU0FBUyxDQUFDLENBQVYsQ0FBMUMsR0FBeUQsZ0JBQTVHOztBQUVBLFlBQUksRUFBRSxNQUFGLEVBQVUsU0FBVixLQUF3QixPQUFPLEdBQW5DLEVBQXdDO0FBQ3BDLGNBQUUsYUFBRixFQUFpQixRQUFqQixDQUEwQixPQUExQjtBQUNILFNBRkQsTUFFTztBQUNILGNBQUUsYUFBRixFQUFpQixXQUFqQixDQUE2QixPQUE3QjtBQUNIO0FBQ0osS0FWRDs7QUFZQSxRQUFJLFFBQVEsU0FBUyxjQUFULENBQXdCLGdCQUF4QixDQUFaOztBQUVBLGFBQVMsT0FBVCxDQUFpQixLQUFqQixFQUF3Qjs7QUFFcEIsWUFBSSxNQUFNLEtBQU4sSUFBZSxNQUFNLEtBQU4sQ0FBWSxDQUFaLENBQW5CLEVBQW1DO0FBQy9CLG9CQUFRLEdBQVIsQ0FBWSxjQUFaO0FBQ0EsZ0JBQUksU0FBUyxJQUFJLFVBQUosRUFBYjs7QUFFQSxtQkFBTyxhQUFQLENBQXFCLE1BQU0sS0FBTixDQUFZLENBQVosQ0FBckI7O0FBRUEsbUJBQU8sTUFBUCxHQUFnQixVQUFTLENBQVQsRUFBWTtBQUN4Qiw4QkFBYyxPQUFkLENBQXNCLEVBQUUsTUFBRixDQUFTLE1BQS9CO0FBQ0gsYUFGRDtBQUdIO0FBQ0o7O0FBRUQsYUFBUyxRQUFULENBQWtCLEtBQWxCLEVBQXlCLFVBQXpCLEVBQXFDOztBQUVqQyxZQUFJLE1BQU0sS0FBTixJQUFlLE1BQU0sS0FBTixDQUFZLENBQVosQ0FBbkIsRUFBbUM7QUFDL0Isb0JBQVEsR0FBUixDQUFZLGNBQVo7QUFDQSxnQkFBSSxTQUFTLElBQUksVUFBSixFQUFiOztBQUVBLG1CQUFPLGFBQVAsQ0FBcUIsTUFBTSxLQUFOLENBQVksQ0FBWixDQUFyQjs7QUFFQSxtQkFBTyxNQUFQLEdBQWdCLFVBQVMsQ0FBVCxFQUFZO0FBQ3hCLGtCQUFFLFVBQUYsRUFBYyxJQUFkLENBQW1CLEtBQW5CLEVBQTBCLEVBQUUsTUFBRixDQUFTLE1BQW5DO0FBQ0gsYUFGRDtBQUdIO0FBQ0o7O0FBRUQsTUFBRSxlQUFGLEVBQW1CLEtBQW5CLENBQXlCLFlBQVc7QUFDaEMsVUFBRSxJQUFGLEVBQVEsUUFBUixHQUFtQixJQUFuQjtBQUNBLFVBQUUsSUFBRixFQUFRLFFBQVIsQ0FBaUIsWUFBakIsRUFBK0IsSUFBL0I7QUFDSCxLQUhEOztBQUtBLE1BQUUsY0FBRixFQUFrQixNQUFsQixDQUF5QixZQUFXO0FBQ2hDLGdCQUFRLElBQVI7QUFDSCxLQUZEOzs7Ozs7Ozs7QUFXQSxNQUFFLFFBQUYsRUFBWSxNQUFaLENBQW1CLFlBQVc7QUFDMUIsaUJBQVMsSUFBVCxFQUFlLFVBQWY7QUFDQSxpQkFBUyxJQUFULEVBQWUsZUFBZjtBQUNBLFVBQUUsVUFBRixFQUFjLElBQWQ7QUFDQSxVQUFFLHVCQUFGLEVBQTJCLElBQTNCO0FBQ0gsS0FMRDs7QUFPQSxRQUFJO0FBQ0EsWUFBSSxnQkFBZ0IsSUFBSSxPQUFKLENBQVksS0FBWixFQUFtQjtBQUNuQyx5QkFBYSxDQURzQjtBQUVuQyxrQkFBTSxVQUFTLENBQVQsRUFBWTs7Ozs7QUFLakI7QUFQa0MsU0FBbkIsQ0FBcEI7QUFTSCxLQVZELENBVUUsT0FBTyxDQUFQLEVBQVUsQ0FBRTs7QUFFZCxNQUFFLGNBQUYsRUFBa0IsRUFBbEIsQ0FBcUIsT0FBckIsRUFBOEIsVUFBUyxDQUFULEVBQVk7QUFDdEMsZ0JBQVEsR0FBUixDQUFZLGlCQUFaO0FBQ0EsWUFBSSxVQUFVLEVBQUUsY0FBRixDQUFkO0FBQ0EsWUFBSSxVQUFVLFFBQVEsSUFBUixDQUFhLFFBQWIsQ0FBZDtBQUNBLFlBQUksUUFBUSxFQUFFLG9CQUFGLENBQVo7O0FBRUEsZ0JBQVEsR0FBUixDQUFZLE9BQVo7QUFDQSxzQkFBYyxnQkFBZCxHQUFpQyxNQUFqQyxDQUF3QyxVQUFTLElBQVQsRUFBZTtBQUNuRCxnQkFBSSxXQUFXLElBQUksUUFBSixFQUFmOztBQUdBLHFCQUFTLE1BQVQsQ0FBZ0IsT0FBaEIsRUFBeUIsSUFBekI7QUFDQSxvQkFBUSxHQUFSLENBQVksUUFBWjs7O0FBR0EsY0FBRSxJQUFGLENBQU87QUFDSCxxQkFBSyxPQURGO0FBRUgsd0JBQVEsTUFGTDtBQUdILHNCQUFNLFFBSEg7QUFJSCx5QkFBUztBQUNMLG9DQUFnQixNQUFNLEdBQU47QUFEWCxpQkFKTjtBQU9ILDZCQUFhLEtBUFY7QUFRSCw2QkFBYSxLQVJWO0FBU0gseUJBQVMsWUFBVztBQUNoQiw0QkFBUSxHQUFSLENBQVksZ0JBQVo7QUFDSCxpQkFYRTtBQVlILHVCQUFPLFlBQVc7QUFDZCw0QkFBUSxHQUFSLENBQVksY0FBWjtBQUNIO0FBZEUsYUFBUDtBQWlCSCxTQXpCRDtBQTBCQSxVQUFFLGNBQUY7QUFDQSxlQUFPLFVBQVAsQ0FBa0IsWUFBVztBQUN6QixxQkFBUyxNQUFUO0FBQ0gsU0FGRCxFQUVHLElBRkg7QUFHSCxLQXJDRDtBQXNDSCxDQXRKRCIsImZpbGUiOiJnZW5lcmF0ZWQuanMiLCJzb3VyY2VSb290IjoiIiwic291cmNlc0NvbnRlbnQiOlsiKGZ1bmN0aW9uIGUodCxuLHIpe2Z1bmN0aW9uIHMobyx1KXtpZighbltvXSl7aWYoIXRbb10pe3ZhciBhPXR5cGVvZiByZXF1aXJlPT1cImZ1bmN0aW9uXCImJnJlcXVpcmU7aWYoIXUmJmEpcmV0dXJuIGEobywhMCk7aWYoaSlyZXR1cm4gaShvLCEwKTt2YXIgZj1uZXcgRXJyb3IoXCJDYW5ub3QgZmluZCBtb2R1bGUgJ1wiK28rXCInXCIpO3Rocm93IGYuY29kZT1cIk1PRFVMRV9OT1RfRk9VTkRcIixmfXZhciBsPW5bb109e2V4cG9ydHM6e319O3Rbb11bMF0uY2FsbChsLmV4cG9ydHMsZnVuY3Rpb24oZSl7dmFyIG49dFtvXVsxXVtlXTtyZXR1cm4gcyhuP246ZSl9LGwsbC5leHBvcnRzLGUsdCxuLHIpfXJldHVybiBuW29dLmV4cG9ydHN9dmFyIGk9dHlwZW9mIHJlcXVpcmU9PVwiZnVuY3Rpb25cIiYmcmVxdWlyZTtmb3IodmFyIG89MDtvPHIubGVuZ3RoO28rKylzKHJbb10pO3JldHVybiBzfSkiLCJcInVzZSBzdHJpY3RcIjtcbiQoZG9jdW1lbnQpLnJlYWR5KGZ1bmN0aW9uKCkge1xuXG4gICAgd2luZG93LnNldFRpbWVvdXQoZnVuY3Rpb24oKSB7XG4gICAgICAgICQoJy5hbGVydC1zdWNjZXNzJykuZmFkZVRvKDUwMCwgMCkuc2xpZGVVcCg1MDAsIGZ1bmN0aW9uKCkge1xuICAgICAgICAgICAgJCh0aGlzKS5yZW1vdmUoKTtcbiAgICAgICAgfSk7XG4gICAgfSwgMzAwMCk7XG5cbiAgICAkKCcuZGVsZXRlLWNvbmZpcm0nKS5vbignc3VibWl0JywgZnVuY3Rpb24oKSB7XG4gICAgICAgIHJldHVybiBjb25maXJtKCdBcmUgeW91IHN1cmUgeW91IHdhbnQgdG8gZGVsZXRlIHRoaXM/Jyk7XG4gICAgfSk7XG5cbiAgICAkKFwiLm9wdXMtc3JjXCIpLnVudmVpbCgpO1xuXG4gICAgJCgnI3ByZXZpZXcnKS5jbGljayhmdW5jdGlvbigpIHtcbiAgICAgICAgJCgnI2Z1bGx2aWV3Jykuc2hvdygpLnVudmVpbCgpO1xuICAgICAgICAkKCcuZnVsbHZpZXctYm94Jykuc2hvdygpO1xuICAgICAgICAkKHRoaXMpLnRvZ2dsZSgpO1xuICAgIH0pO1xuXG4gICAgJCgnI2Z1bGx2aWV3JykuY2xpY2soZnVuY3Rpb24oKSB7XG4gICAgICAgICQodGhpcykudG9nZ2xlKCk7XG4gICAgICAgICQoJy5mdWxsdmlldy1ib3gnKS50b2dnbGUoKTtcbiAgICAgICAgJCgnI3ByZXZpZXcnKS50b2dnbGUoKTtcbiAgICB9KTtcblxuICAgICQoJyNzZWxlY3RBbGxPcHVzJykuY2xpY2soZnVuY3Rpb24oKSB7XG4gICAgICAgIHZhciBjaGVja2JveCA9ICQoJy5vcHVzLW1lc3NhZ2Utc2VsZWN0Jyk7XG4gICAgICAgIGNoZWNrYm94LnByb3AoJ2NoZWNrZWQnLCAhY2hlY2tib3guaXMoXCI6Y2hlY2tlZFwiKSk7XG4gICAgfSk7XG5cblxuICAgIC8vdmFyIG51bSA9IDE1MDsgLy9udW1iZXIgb2YgcGl4ZWxzIGJlZm9yZSBtb2RpZnlpbmcgc3R5bGVzXG4gICAgdmFyIG5hdnBvcyA9ICQoJy50b3AtaGVhZGVyJykub2Zmc2V0KCk7XG5cbiAgICAkKHdpbmRvdykuYmluZCgnc2Nyb2xsJywgZnVuY3Rpb24oKSB7XG5cbiAgICAgICAgdmFyIHggPSAkKHRoaXMpLnNjcm9sbFRvcCgpO1xuICAgICAgICAkKCcjaGVhZGVyLWJhY2tncm91bmQnKS5jc3MoJ2JhY2tncm91bmQtcG9zaXRpb24nLCAnMTAwJSAnICsgcGFyc2VJbnQoLXgpICsgJ3B4JyArICcsIDAlICcgKyBwYXJzZUludCgteCkgKyAncHgsIGNlbnRlciB0b3AnKTtcblxuICAgICAgICBpZiAoJCh3aW5kb3cpLnNjcm9sbFRvcCgpID4gbmF2cG9zLnRvcCkge1xuICAgICAgICAgICAgJCgnLnRvcC1oZWFkZXInKS5hZGRDbGFzcygnZml4ZWQnKTtcbiAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAgICQoJy50b3AtaGVhZGVyJykucmVtb3ZlQ2xhc3MoJ2ZpeGVkJyk7XG4gICAgICAgIH1cbiAgICB9KTtcblxuICAgIHZhciBpbWFnZSA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdhdmF0YXItY3JvcHBlcicpO1xuXG4gICAgZnVuY3Rpb24gcmVhZFVSTChpbnB1dCkge1xuXG4gICAgICAgIGlmIChpbnB1dC5maWxlcyAmJiBpbnB1dC5maWxlc1swXSkge1xuICAgICAgICAgICAgY29uc29sZS5sb2coJ1JlYWRpbmcgZmlsZScpO1xuICAgICAgICAgICAgdmFyIHJlYWRlciA9IG5ldyBGaWxlUmVhZGVyKCk7XG5cbiAgICAgICAgICAgIHJlYWRlci5yZWFkQXNEYXRhVVJMKGlucHV0LmZpbGVzWzBdKTtcblxuICAgICAgICAgICAgcmVhZGVyLm9ubG9hZCA9IGZ1bmN0aW9uKGUpIHtcbiAgICAgICAgICAgICAgICBhdmF0YXJDcm9wcGVyLnJlcGxhY2UoZS50YXJnZXQucmVzdWx0KTtcbiAgICAgICAgICAgIH07XG4gICAgICAgIH1cbiAgICB9XG5cbiAgICBmdW5jdGlvbiByZWFkRmlsZShpbnB1dCwgaW1nRWxlbWVudCkge1xuXG4gICAgICAgIGlmIChpbnB1dC5maWxlcyAmJiBpbnB1dC5maWxlc1swXSkge1xuICAgICAgICAgICAgY29uc29sZS5sb2coJ1JlYWRpbmcgZmlsZScpO1xuICAgICAgICAgICAgdmFyIHJlYWRlciA9IG5ldyBGaWxlUmVhZGVyKCk7XG5cbiAgICAgICAgICAgIHJlYWRlci5yZWFkQXNEYXRhVVJMKGlucHV0LmZpbGVzWzBdKTtcblxuICAgICAgICAgICAgcmVhZGVyLm9ubG9hZCA9IGZ1bmN0aW9uKGUpIHtcbiAgICAgICAgICAgICAgICAkKGltZ0VsZW1lbnQpLmF0dHIoJ3NyYycsIGUudGFyZ2V0LnJlc3VsdCk7XG4gICAgICAgICAgICB9O1xuICAgICAgICB9XG4gICAgfVxuXG4gICAgJCgnLnJlcGx5LXRvZ2dsZScpLmNsaWNrKGZ1bmN0aW9uKCkge1xuICAgICAgICAkKHRoaXMpLmNoaWxkcmVuKCkuc2hvdygpO1xuICAgICAgICAkKHRoaXMpLmNoaWxkcmVuKCcucmVwbHktYnRuJykuaGlkZSgpO1xuICAgIH0pO1xuXG4gICAgJCgnI2F2YXRhci1maWxlJykuY2hhbmdlKGZ1bmN0aW9uKCkge1xuICAgICAgICByZWFkVVJMKHRoaXMpO1xuICAgIH0pO1xuXG4gICAgLy8gJCgnLm9wdXMtb3ZlcmxheScpLm9uKCdob3ZlcicsIGZ1bmN0aW9uKCkge1xuICAgIC8vICAgICBjb25zb2xlLmxvZygnb3ZlcmxheSB0cmlnZ2VyJyk7XG4gICAgLy8gICAgICQodGhpcykuZmFkZUluKDMwMCk7XG4gICAgLy8gfSwgZnVuY3Rpb24oKSB7XG4gICAgLy8gICAgICQodGhpcykuZmFkZU91dCgzMDApO1xuICAgIC8vIH0pO1xuXG4gICAgJCgnI2ltYWdlJykuY2hhbmdlKGZ1bmN0aW9uKCkge1xuICAgICAgICByZWFkRmlsZSh0aGlzLCAnI3ByZXZpZXcnKTtcbiAgICAgICAgcmVhZEZpbGUodGhpcywgJyNwcmV2aWV3LWVkaXQnKTtcbiAgICAgICAgJCgnI3ByZXZpZXcnKS5zaG93KCk7XG4gICAgICAgICQoJ2Rpdi5wcmV2aWV3LWNvbnRhaW5lcicpLnNob3coKTtcbiAgICB9KTtcblxuICAgIHRyeSB7XG4gICAgICAgIHZhciBhdmF0YXJDcm9wcGVyID0gbmV3IENyb3BwZXIoaW1hZ2UsIHtcbiAgICAgICAgICAgIGFzcGVjdFJhdGlvOiAxLFxuICAgICAgICAgICAgY3JvcDogZnVuY3Rpb24oZSkge1xuICAgICAgICAgICAgICAgIC8vIGNvbnNvbGUubG9nKGUuZGV0YWlsLngpO1xuICAgICAgICAgICAgICAgIC8vIGNvbnNvbGUubG9nKGUuZGV0YWlsLnkpO1xuICAgICAgICAgICAgICAgIC8vIGNvbnNvbGUubG9nKGUuZGV0YWlsLndpZHRoKTtcbiAgICAgICAgICAgICAgICAvLyBjb25zb2xlLmxvZyhlLmRldGFpbC5oZWlnaHQpO1xuICAgICAgICAgICAgfVxuICAgICAgICB9KTtcbiAgICB9IGNhdGNoIChlKSB7fVxuXG4gICAgJCgnLmNyb3Atc3VibWl0Jykub24oJ2NsaWNrJywgZnVuY3Rpb24oZSkge1xuICAgICAgICBjb25zb2xlLmxvZygnQ3JvcHBpbmcgYXZhdGFyJyk7XG4gICAgICAgIHZhciBmb3JtT2JqID0gJCgnI2F2YXRhci1mb3JtJyk7XG4gICAgICAgIHZhciBmb3JtVVJMID0gZm9ybU9iai5hdHRyKFwiYWN0aW9uXCIpO1xuICAgICAgICB2YXIgdG9rZW4gPSAkKCdpbnB1dFtuYW1lPV90b2tlbl0nKTtcblxuICAgICAgICBjb25zb2xlLmxvZyhmb3JtVVJMKTtcbiAgICAgICAgYXZhdGFyQ3JvcHBlci5nZXRDcm9wcGVkQ2FudmFzKCkudG9CbG9iKGZ1bmN0aW9uKGJsb2IpIHtcbiAgICAgICAgICAgIHZhciBmb3JtRGF0YSA9IG5ldyBGb3JtRGF0YSgpO1xuXG5cbiAgICAgICAgICAgIGZvcm1EYXRhLmFwcGVuZCgnaW1hZ2UnLCBibG9iKTtcbiAgICAgICAgICAgIGNvbnNvbGUubG9nKGZvcm1EYXRhKTtcblxuICAgICAgICAgICAgLy8gVXNlIGBqUXVlcnkuYWpheGAgbWV0aG9kXG4gICAgICAgICAgICAkLmFqYXgoe1xuICAgICAgICAgICAgICAgIHVybDogZm9ybVVSTCxcbiAgICAgICAgICAgICAgICBtZXRob2Q6IFwiUE9TVFwiLFxuICAgICAgICAgICAgICAgIGRhdGE6IGZvcm1EYXRhLFxuICAgICAgICAgICAgICAgIGhlYWRlcnM6IHtcbiAgICAgICAgICAgICAgICAgICAgJ1gtQ1NSRi1UT0tFTic6IHRva2VuLnZhbCgpXG4gICAgICAgICAgICAgICAgfSxcbiAgICAgICAgICAgICAgICBwcm9jZXNzRGF0YTogZmFsc2UsXG4gICAgICAgICAgICAgICAgY29udGVudFR5cGU6IGZhbHNlLFxuICAgICAgICAgICAgICAgIHN1Y2Nlc3M6IGZ1bmN0aW9uKCkge1xuICAgICAgICAgICAgICAgICAgICBjb25zb2xlLmxvZygnVXBsb2FkIHN1Y2Nlc3MnKTtcbiAgICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgICAgIGVycm9yOiBmdW5jdGlvbigpIHtcbiAgICAgICAgICAgICAgICAgICAgY29uc29sZS5sb2coJ1VwbG9hZCBlcnJvcicpO1xuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgIH0pO1xuXG4gICAgICAgIH0pO1xuICAgICAgICBlLnByZXZlbnREZWZhdWx0KCk7XG4gICAgICAgIHdpbmRvdy5zZXRUaW1lb3V0KGZ1bmN0aW9uKCkge1xuICAgICAgICAgICAgbG9jYXRpb24ucmVsb2FkKCk7XG4gICAgICAgIH0sIDIwMDApXG4gICAgfSk7XG59KTsiXX0=
