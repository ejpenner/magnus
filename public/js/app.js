(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
"use strict";

$(document).ready(function () {

    var fullview = $('#fullview');
    var preview = $('#preview');
    var hashVal = window.location.hash;
    var topHeader = $('.top-header');
    var navpos = topHeader.offset();
    var sortButton = $('.button-container');
    var sortButtonPos = sortButton.offset();
    var image = document.getElementById('avatar-cropper');

    window.setTimeout(function () {
        $('.alert-success').fadeTo(500, 0).slideUp(500, function () {
            $(this).remove();
        });
    }, 3000);

    $('.delete-confirm').on('submit', function () {
        return confirm('Are you sure you want to delete this?');
    });

    preview.click(function () {
        $('.fullview-box').show();
        //$('#opus-image').css('width', '100%');
        $(this).toggle();
        fullview.show().unveil();
    });

    fullview.click(function () {
        $(this).toggle();
        //$('#opus-image').css('width', '80%');
        $('.fullview-box').toggle();
        preview.toggle();
    });

    if (hashVal.indexOf('full') != -1) {
        preview.toggle();
        $('.fullview-box').show();
        fullview.show().unveil();
    }

    $('#selectAllOpus').click(function () {
        var checkbox = $('.opus-message-select');
        checkbox.prop('checked', !checkbox.is(":checked"));
    });

    //var num = 150; //number of pixels before modifying styles

    $(window).bind('scroll', function () {

        var x = $(this).scrollTop();
        $('#header-background').css('background-position', '100% ' + parseInt(-x) + 'px' + ', 0% ' + parseInt(-x) + 'px, center top');

        if ($(window).scrollTop() > navpos.top) {
            topHeader.addClass('fixed');
        } else {
            topHeader.removeClass('fixed');
        }
        try {
            if ($(window).scrollTop() > sortButtonPos.top - parseInt(2 * sortButton.height())) {
                $('.button-container').addClass('fixed-buttons');
            } else {
                $('.button-container').removeClass('fixed-buttons');
            }
        } catch (e) {}
    });

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

    var $replyToggle = $('.reply-toggle');

    $replyToggle.click(function () {
        $(this).children().show();
        $(this).children('.reply-btn').hide();
    });

    var anchor = window.location.hash;
    if (anchor == '#replyTop') {
        $(anchor).children('.reply-form').show();
        $(anchor).children('.reply-btn').hide();
    }

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
        readFile(this, '#preview-upload');
        readFile(this, '#preview-edit');
        $('#preview-upload').show();
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
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIm5vZGVfbW9kdWxlcy9icm93c2VyaWZ5L25vZGVfbW9kdWxlcy9icm93c2VyLXBhY2svX3ByZWx1ZGUuanMiLCJyZXNvdXJjZXMvYXNzZXRzL2pzL2FwcC5qcyJdLCJuYW1lcyI6W10sIm1hcHBpbmdzIjoiQUFBQTtBQ0FBOztBQUNBLEVBQUUsUUFBRixFQUFZLEtBQVosQ0FBa0IsWUFBVzs7QUFFekIsUUFBSSxXQUFXLEVBQUUsV0FBRixDQUFmO0FBQ0EsUUFBSSxVQUFVLEVBQUUsVUFBRixDQUFkO0FBQ0EsUUFBSSxVQUFVLE9BQU8sUUFBUCxDQUFnQixJQUE5QjtBQUNBLFFBQUksWUFBWSxFQUFFLGFBQUYsQ0FBaEI7QUFDQSxRQUFJLFNBQVMsVUFBVSxNQUFWLEVBQWI7QUFDQSxRQUFJLGFBQWEsRUFBRSxtQkFBRixDQUFqQjtBQUNBLFFBQUksZ0JBQWdCLFdBQVcsTUFBWCxFQUFwQjtBQUNBLFFBQUksUUFBUSxTQUFTLGNBQVQsQ0FBd0IsZ0JBQXhCLENBQVo7O0FBRUEsV0FBTyxVQUFQLENBQWtCLFlBQVc7QUFDekIsVUFBRSxnQkFBRixFQUFvQixNQUFwQixDQUEyQixHQUEzQixFQUFnQyxDQUFoQyxFQUFtQyxPQUFuQyxDQUEyQyxHQUEzQyxFQUFnRCxZQUFXO0FBQ3ZELGNBQUUsSUFBRixFQUFRLE1BQVI7QUFDSCxTQUZEO0FBR0gsS0FKRCxFQUlHLElBSkg7O0FBTUEsTUFBRSxpQkFBRixFQUFxQixFQUFyQixDQUF3QixRQUF4QixFQUFrQyxZQUFXO0FBQ3pDLGVBQU8sUUFBUSx1Q0FBUixDQUFQO0FBQ0gsS0FGRDs7QUFJQSxZQUFRLEtBQVIsQ0FBYyxZQUFXO0FBQ3JCLFVBQUUsZUFBRixFQUFtQixJQUFuQjtBQUNBO0FBQ0EsVUFBRSxJQUFGLEVBQVEsTUFBUjtBQUNBLGlCQUFTLElBQVQsR0FBZ0IsTUFBaEI7QUFDSCxLQUxEOztBQU9BLGFBQVMsS0FBVCxDQUFlLFlBQVc7QUFDdEIsVUFBRSxJQUFGLEVBQVEsTUFBUjtBQUNBO0FBQ0Es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QUFFQTtBQUNBLGNBQUUsSUFBRixDQUFPO0FBQ0gscUJBQUssT0FERjtBQUVILHdCQUFRLE1BRkw7QUFHSCxzQkFBTSxRQUhIO0FBSUgseUJBQVM7QUFDTCxvQ0FBZ0IsTUFBTSxHQUFOO0FBRFgsaUJBSk47QUFPSCw2QkFBYSxLQVBWO0FBUUgsNkJBQWEsS0FSVjtBQVNILHlCQUFTLFlBQVc7QUFDaEIsNEJBQVEsR0FBUixDQUFZLGdCQUFaO0FBQ0gsaUJBWEU7QUFZSCx1QkFBTyxZQUFXO0FBQ2QsNEJBQVEsR0FBUixDQUFZLGNBQVo7QUFDSDtBQWRFLGFBQVA7QUFpQkgsU0F6QkQ7O0FBMkJBLFVBQUUsY0FBRjs7QUFFQSxlQUFPLFVBQVAsQ0FBa0IsWUFBVztBQUN6QixxQkFBUyxNQUFUO0FBQ0gsU0FGRCxFQUVHLElBRkg7QUFHSCxLQXZDRDtBQXdDSCxDQXJMRCIsImZpbGUiOiJnZW5lcmF0ZWQuanMiLCJzb3VyY2VSb290IjoiIiwic291cmNlc0NvbnRlbnQiOlsiKGZ1bmN0aW9uIGUodCxuLHIpe2Z1bmN0aW9uIHMobyx1KXtpZighbltvXSl7aWYoIXRbb10pe3ZhciBhPXR5cGVvZiByZXF1aXJlPT1cImZ1bmN0aW9uXCImJnJlcXVpcmU7aWYoIXUmJmEpcmV0dXJuIGEobywhMCk7aWYoaSlyZXR1cm4gaShvLCEwKTt2YXIgZj1uZXcgRXJyb3IoXCJDYW5ub3QgZmluZCBtb2R1bGUgJ1wiK28rXCInXCIpO3Rocm93IGYuY29kZT1cIk1PRFVMRV9OT1RfRk9VTkRcIixmfXZhciBsPW5bb109e2V4cG9ydHM6e319O3Rbb11bMF0uY2FsbChsLmV4cG9ydHMsZnVuY3Rpb24oZSl7dmFyIG49dFtvXVsxXVtlXTtyZXR1cm4gcyhuP246ZSl9LGwsbC5leHBvcnRzLGUsdCxuLHIpfXJldHVybiBuW29dLmV4cG9ydHN9dmFyIGk9dHlwZW9mIHJlcXVpcmU9PVwiZnVuY3Rpb25cIiYmcmVxdWlyZTtmb3IodmFyIG89MDtvPHIubGVuZ3RoO28rKylzKHJbb10pO3JldHVybiBzfSkiLCJcInVzZSBzdHJpY3RcIjtcbiQoZG9jdW1lbnQpLnJlYWR5KGZ1bmN0aW9uKCkge1xuXG4gICAgdmFyIGZ1bGx2aWV3ID0gJCgnI2Z1bGx2aWV3Jyk7XG4gICAgdmFyIHByZXZpZXcgPSAkKCcjcHJldmlldycpO1xuICAgIHZhciBoYXNoVmFsID0gd2luZG93LmxvY2F0aW9uLmhhc2g7XG4gICAgdmFyIHRvcEhlYWRlciA9ICQoJy50b3AtaGVhZGVyJyk7XG4gICAgdmFyIG5hdnBvcyA9IHRvcEhlYWRlci5vZmZzZXQoKTtcbiAgICB2YXIgc29ydEJ1dHRvbiA9ICQoJy5idXR0b24tY29udGFpbmVyJyk7XG4gICAgdmFyIHNvcnRCdXR0b25Qb3MgPSBzb3J0QnV0dG9uLm9mZnNldCgpO1xuICAgIHZhciBpbWFnZSA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdhdmF0YXItY3JvcHBlcicpO1xuXG4gICAgd2luZG93LnNldFRpbWVvdXQoZnVuY3Rpb24oKSB7XG4gICAgICAgICQoJy5hbGVydC1zdWNjZXNzJykuZmFkZVRvKDUwMCwgMCkuc2xpZGVVcCg1MDAsIGZ1bmN0aW9uKCkge1xuICAgICAgICAgICAgJCh0aGlzKS5yZW1vdmUoKTtcbiAgICAgICAgfSk7XG4gICAgfSwgMzAwMCk7XG5cbiAgICAkKCcuZGVsZXRlLWNvbmZpcm0nKS5vbignc3VibWl0JywgZnVuY3Rpb24oKSB7XG4gICAgICAgIHJldHVybiBjb25maXJtKCdBcmUgeW91IHN1cmUgeW91IHdhbnQgdG8gZGVsZXRlIHRoaXM/Jyk7XG4gICAgfSk7XG5cbiAgICBwcmV2aWV3LmNsaWNrKGZ1bmN0aW9uKCkge1xuICAgICAgICAkKCcuZnVsbHZpZXctYm94Jykuc2hvdygpO1xuICAgICAgICAvLyQoJyNvcHVzLWltYWdlJykuY3NzKCd3aWR0aCcsICcxMDAlJyk7XG4gICAgICAgICQodGhpcykudG9nZ2xlKCk7XG4gICAgICAgIGZ1bGx2aWV3LnNob3coKS51bnZlaWwoKTtcbiAgICB9KTtcblxuICAgIGZ1bGx2aWV3LmNsaWNrKGZ1bmN0aW9uKCkge1xuICAgICAgICAkKHRoaXMpLnRvZ2dsZSgpO1xuICAgICAgICAvLyQoJyNvcHVzLWltYWdlJykuY3NzKCd3aWR0aCcsICc4MCUnKTtcbiAgICAgICAgJCgnLmZ1bGx2aWV3LWJveCcpLnRvZ2dsZSgpO1xuICAgICAgICBwcmV2aWV3LnRvZ2dsZSgpO1xuICAgIH0pO1xuXG4gICAgaWYgKGhhc2hWYWwuaW5kZXhPZignZnVsbCcpICE9IC0xKSB7XG4gICAgICAgIHByZXZpZXcudG9nZ2xlKCk7XG4gICAgICAgICQoJy5mdWxsdmlldy1ib3gnKS5zaG93KCk7XG4gICAgICAgIGZ1bGx2aWV3LnNob3coKS51bnZlaWwoKTtcbiAgICB9XG5cbiAgICAkKCcjc2VsZWN0QWxsT3B1cycpLmNsaWNrKGZ1bmN0aW9uKCkge1xuICAgICAgICB2YXIgY2hlY2tib3ggPSAkKCcub3B1cy1tZXNzYWdlLXNlbGVjdCcpO1xuICAgICAgICBjaGVja2JveC5wcm9wKCdjaGVja2VkJywgIWNoZWNrYm94LmlzKFwiOmNoZWNrZWRcIikpO1xuICAgIH0pO1xuXG5cbiAgICAvL3ZhciBudW0gPSAxNTA7IC8vbnVtYmVyIG9mIHBpeGVscyBiZWZvcmUgbW9kaWZ5aW5nIHN0eWxlc1xuXG4gICAgJCh3aW5kb3cpLmJpbmQoJ3Njcm9sbCcsIGZ1bmN0aW9uKCkge1xuXG4gICAgICAgIHZhciB4ID0gJCh0aGlzKS5zY3JvbGxUb3AoKTtcbiAgICAgICAgJCgnI2hlYWRlci1iYWNrZ3JvdW5kJykuY3NzKCdiYWNrZ3JvdW5kLXBvc2l0aW9uJywgJzEwMCUgJyArIHBhcnNlSW50KC14KSArICdweCcgKyAnLCAwJSAnICsgcGFyc2VJbnQoLXgpICsgJ3B4LCBjZW50ZXIgdG9wJyk7XG5cbiAgICAgICAgaWYgKCQod2luZG93KS5zY3JvbGxUb3AoKSA+IG5hdnBvcy50b3ApIHtcbiAgICAgICAgICAgIHRvcEhlYWRlci5hZGRDbGFzcygnZml4ZWQnKTtcbiAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAgIHRvcEhlYWRlci5yZW1vdmVDbGFzcygnZml4ZWQnKTtcbiAgICAgICAgfVxuICAgICAgICB0cnkge1xuICAgICAgICAgICAgaWYgKCQod2luZG93KS5zY3JvbGxUb3AoKSA+IHNvcnRCdXR0b25Qb3MudG9wIC0gcGFyc2VJbnQoMiAqIHNvcnRCdXR0b24uaGVpZ2h0KCkpKSB7XG4gICAgICAgICAgICAgICAgJCgnLmJ1dHRvbi1jb250YWluZXInKS5hZGRDbGFzcygnZml4ZWQtYnV0dG9ucycpO1xuICAgICAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAgICAgICAkKCcuYnV0dG9uLWNvbnRhaW5lcicpLnJlbW92ZUNsYXNzKCdmaXhlZC1idXR0b25zJyk7XG4gICAgICAgICAgICB9XG4gICAgICAgIH0gY2F0Y2ggKGUpIHt9XG4gICAgfSk7XG5cbiAgICBmdW5jdGlvbiByZWFkVVJMKGlucHV0KSB7XG5cbiAgICAgICAgaWYgKGlucHV0LmZpbGVzICYmIGlucHV0LmZpbGVzWzBdKSB7XG4gICAgICAgICAgICBjb25zb2xlLmxvZygnUmVhZGluZyBmaWxlJyk7XG4gICAgICAgICAgICB2YXIgcmVhZGVyID0gbmV3IEZpbGVSZWFkZXIoKTtcblxuICAgICAgICAgICAgcmVhZGVyLnJlYWRBc0RhdGFVUkwoaW5wdXQuZmlsZXNbMF0pO1xuXG4gICAgICAgICAgICByZWFkZXIub25sb2FkID0gZnVuY3Rpb24oZSkge1xuICAgICAgICAgICAgICAgIGF2YXRhckNyb3BwZXIucmVwbGFjZShlLnRhcmdldC5yZXN1bHQpO1xuICAgICAgICAgICAgfTtcbiAgICAgICAgfVxuICAgIH1cblxuICAgIGZ1bmN0aW9uIHJlYWRGaWxlKGlucHV0LCBpbWdFbGVtZW50KSB7XG5cbiAgICAgICAgaWYgKGlucHV0LmZpbGVzICYmIGlucHV0LmZpbGVzWzBdKSB7XG4gICAgICAgICAgICBjb25zb2xlLmxvZygnUmVhZGluZyBmaWxlJyk7XG4gICAgICAgICAgICB2YXIgcmVhZGVyID0gbmV3IEZpbGVSZWFkZXIoKTtcblxuICAgICAgICAgICAgcmVhZGVyLnJlYWRBc0RhdGFVUkwoaW5wdXQuZmlsZXNbMF0pO1xuXG4gICAgICAgICAgICByZWFkZXIub25sb2FkID0gZnVuY3Rpb24oZSkge1xuICAgICAgICAgICAgICAgICQoaW1nRWxlbWVudCkuYXR0cignc3JjJywgZS50YXJnZXQucmVzdWx0KTtcbiAgICAgICAgICAgIH07XG4gICAgICAgIH1cbiAgICB9XG5cbiAgICB2YXIgJHJlcGx5VG9nZ2xlID0gJCgnLnJlcGx5LXRvZ2dsZScpO1xuXG4gICAgJHJlcGx5VG9nZ2xlLmNsaWNrKGZ1bmN0aW9uKCkge1xuICAgICAgICAkKHRoaXMpLmNoaWxkcmVuKCkuc2hvdygpO1xuICAgICAgICAkKHRoaXMpLmNoaWxkcmVuKCcucmVwbHktYnRuJykuaGlkZSgpO1xuICAgIH0pO1xuXG5cbiAgICB2YXIgYW5jaG9yID0gd2luZG93LmxvY2F0aW9uLmhhc2g7XG4gICAgaWYgKGFuY2hvciA9PSAnI3JlcGx5VG9wJykge1xuICAgICAgICAkKGFuY2hvcikuY2hpbGRyZW4oJy5yZXBseS1mb3JtJykuc2hvdygpO1xuICAgICAgICAkKGFuY2hvcikuY2hpbGRyZW4oJy5yZXBseS1idG4nKS5oaWRlKCk7XG4gICAgfVxuXG5cbiAgICAkKCcjYXZhdGFyLWZpbGUnKS5jaGFuZ2UoZnVuY3Rpb24oKSB7XG4gICAgICAgIHJlYWRVUkwodGhpcyk7XG4gICAgfSk7XG5cbiAgICAvLyAkKCcub3B1cy1vdmVybGF5Jykub24oJ2hvdmVyJywgZnVuY3Rpb24oKSB7XG4gICAgLy8gICAgIGNvbnNvbGUubG9nKCdvdmVybGF5IHRyaWdnZXInKTtcbiAgICAvLyAgICAgJCh0aGlzKS5mYWRlSW4oMzAwKTtcbiAgICAvLyB9LCBmdW5jdGlvbigpIHtcbiAgICAvLyAgICAgJCh0aGlzKS5mYWRlT3V0KDMwMCk7XG4gICAgLy8gfSk7XG5cbiAgICAkKCcjaW1hZ2UnKS5jaGFuZ2UoZnVuY3Rpb24oKSB7XG4gICAgICAgIHJlYWRGaWxlKHRoaXMsICcjcHJldmlldy11cGxvYWQnKTtcbiAgICAgICAgcmVhZEZpbGUodGhpcywgJyNwcmV2aWV3LWVkaXQnKTtcbiAgICAgICAgJCgnI3ByZXZpZXctdXBsb2FkJykuc2hvdygpO1xuICAgICAgICAkKCdkaXYucHJldmlldy1jb250YWluZXInKS5zaG93KCk7XG4gICAgfSk7XG5cbiAgICB0cnkge1xuICAgICAgICB2YXIgYXZhdGFyQ3JvcHBlciA9IG5ldyBDcm9wcGVyKGltYWdlLCB7XG4gICAgICAgICAgICBhc3BlY3RSYXRpbzogMSxcbiAgICAgICAgICAgIGNyb3A6IGZ1bmN0aW9uKGUpIHtcbiAgICAgICAgICAgICAgICAvLyBjb25zb2xlLmxvZyhlLmRldGFpbC54KTtcbiAgICAgICAgICAgICAgICAvLyBjb25zb2xlLmxvZyhlLmRldGFpbC55KTtcbiAgICAgICAgICAgICAgICAvLyBjb25zb2xlLmxvZyhlLmRldGFpbC53aWR0aCk7XG4gICAgICAgICAgICAgICAgLy8gY29uc29sZS5sb2coZS5kZXRhaWwuaGVpZ2h0KTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgfSk7XG4gICAgfSBjYXRjaCAoZSkge31cblxuICAgICQoJy5jcm9wLXN1Ym1pdCcpLm9uKCdjbGljaycsIGZ1bmN0aW9uKGUpIHtcbiAgICAgICAgY29uc29sZS5sb2coJ0Nyb3BwaW5nIGF2YXRhcicpO1xuICAgICAgICB2YXIgZm9ybU9iaiA9ICQoJyNhdmF0YXItZm9ybScpO1xuICAgICAgICB2YXIgZm9ybVVSTCA9IGZvcm1PYmouYXR0cihcImFjdGlvblwiKTtcbiAgICAgICAgdmFyIHRva2VuID0gJCgnaW5wdXRbbmFtZT1fdG9rZW5dJyk7XG5cbiAgICAgICAgY29uc29sZS5sb2coZm9ybVVSTCk7XG4gICAgICAgIGF2YXRhckNyb3BwZXIuZ2V0Q3JvcHBlZENhbnZhcygpLnRvQmxvYihmdW5jdGlvbihibG9iKSB7XG4gICAgICAgICAgICB2YXIgZm9ybURhdGEgPSBuZXcgRm9ybURhdGEoKTtcblxuXG4gICAgICAgICAgICBmb3JtRGF0YS5hcHBlbmQoJ2ltYWdlJywgYmxvYik7XG4gICAgICAgICAgICBjb25zb2xlLmxvZyhmb3JtRGF0YSk7XG5cbiAgICAgICAgICAgIC8vIFVzZSBgalF1ZXJ5LmFqYXhgIG1ldGhvZFxuICAgICAgICAgICAgJC5hamF4KHtcbiAgICAgICAgICAgICAgICB1cmw6IGZvcm1VUkwsXG4gICAgICAgICAgICAgICAgbWV0aG9kOiBcIlBPU1RcIixcbiAgICAgICAgICAgICAgICBkYXRhOiBmb3JtRGF0YSxcbiAgICAgICAgICAgICAgICBoZWFkZXJzOiB7XG4gICAgICAgICAgICAgICAgICAgICdYLUNTUkYtVE9LRU4nOiB0b2tlbi52YWwoKVxuICAgICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICAgICAgcHJvY2Vzc0RhdGE6IGZhbHNlLFxuICAgICAgICAgICAgICAgIGNvbnRlbnRUeXBlOiBmYWxzZSxcbiAgICAgICAgICAgICAgICBzdWNjZXNzOiBmdW5jdGlvbigpIHtcbiAgICAgICAgICAgICAgICAgICAgY29uc29sZS5sb2coJ1VwbG9hZCBzdWNjZXNzJyk7XG4gICAgICAgICAgICAgICAgfSxcbiAgICAgICAgICAgICAgICBlcnJvcjogZnVuY3Rpb24oKSB7XG4gICAgICAgICAgICAgICAgICAgIGNvbnNvbGUubG9nKCdVcGxvYWQgZXJyb3InKTtcbiAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICB9KTtcblxuICAgICAgICB9KTtcblxuICAgICAgICBlLnByZXZlbnREZWZhdWx0KCk7XG5cbiAgICAgICAgd2luZG93LnNldFRpbWVvdXQoZnVuY3Rpb24oKSB7XG4gICAgICAgICAgICBsb2NhdGlvbi5yZWxvYWQoKTtcbiAgICAgICAgfSwgMjAwMClcbiAgICB9KTtcbn0pOyJdfQ==
