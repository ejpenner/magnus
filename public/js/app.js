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
    var sortButton = $('.button-container');
    var sortButtonPos = sortButton.offset();

    $(window).bind('scroll', function () {

        var x = $(this).scrollTop();
        $('#header-background').css('background-position', '100% ' + parseInt(-x) + 'px' + ', 0% ' + parseInt(-x) + 'px, center top');

        if ($(window).scrollTop() > navpos.top) {
            $('.top-header').addClass('fixed');
        } else {
            $('.top-header').removeClass('fixed');
        }

        if ($(window).scrollTop() > sortButtonPos.top - parseInt(2 * sortButton.height())) {
            $('.button-container').addClass('fixed-buttons');
        } else {
            $('.button-container').removeClass('fixed-buttons');
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
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIi4uLy4uLy5ucG0tbG9jYWwvZ2FsbGVyeS1hcHAvbm9kZV9tb2R1bGVzL2Jyb3dzZXJpZnkvbm9kZV9tb2R1bGVzL2Jyb3dzZXItcGFjay9fcHJlbHVkZS5qcyIsInJlc291cmNlcy9hc3NldHMvanMvYXBwLmpzIl0sIm5hbWVzIjpbXSwibWFwcGluZ3MiOiJBQUFBO0FDQUE7O0FBQ0EsRUFBRSxRQUFGLEVBQVksS0FBWixDQUFrQixZQUFXOztBQUV6QixXQUFPLFVBQVAsQ0FBa0IsWUFBVztBQUN6QixVQUFFLGdCQUFGLEVBQW9CLE1BQXBCLENBQTJCLEdBQTNCLEVBQWdDLENBQWhDLEVBQW1DLE9BQW5DLENBQTJDLEdBQTNDLEVBQWdELFlBQVc7QUFDdkQsY0FBRSxJQUFGLEVBQVEsTUFBUjtBQUNILFNBRkQ7QUFHSCxLQUpELEVBSUcsSUFKSDs7QUFNQSxNQUFFLGlCQUFGLEVBQXFCLEVBQXJCLENBQXdCLFFBQXhCLEVBQWtDLFlBQVc7QUFDekMsZUFBTyxRQUFRLHVDQUFSLENBQVA7QUFDSCxLQUZEOztBQUlBLE1BQUUsV0FBRixFQUFlLE1BQWY7O0FBRUEsTUFBRSxVQUFGLEVBQWMsS0FBZCxDQUFvQixZQUFXO0FBQzNCLFVBQUUsV0FBRixFQUFlLElBQWYsR0FBc0IsTUFBdEI7QUFDQSxVQUFFLGVBQUYsRUFBbUIsSUFBbkI7QUFDQSxVQUFFLElBQUYsRUFBUSxNQUFSO0FBQ0gsS0FKRDs7QUFNQSxNQUFFLFdBQUYsRUFBZSxLQUFmLENBQXFCLFlBQVc7QUFDNUIsVUFBRSxJQUFGLEVBQVEsTUFBUjtBQUNBLFVBQUUsZUFBRixFQUFtQixNQUFuQjtBQUNBLFVBQUUsVUFBRixFQUFjLE1BQWQ7QUFDSCxLQUpEOztBQU1BLE1BQUUsZ0JBQUYsRUFBb0IsS0FBcEIsQ0FBMEIsWUFBVztBQUNqQyxZQUFJLFdBQVcsRUFBRSxzQkFBRixDQUFmO0FBQ0EsaUJBQVMsSUFBVCxDQUFjLFNBQWQsRUFBeUIsQ0FBQyxTQUFTLEVBQVQsQ0FBWSxVQUFaLENBQTFC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QUFZLGNBQVo7QUFDSDtBQWRFLGFBQVA7QUFpQkgsU0F6QkQ7QUEwQkEsVUFBRSxjQUFGO0FBQ0EsZUFBTyxVQUFQLENBQWtCLFlBQVc7QUFDekIscUJBQVMsTUFBVDtBQUNILFNBRkQsRUFFRyxJQUZIO0FBR0gsS0FyQ0Q7QUFzQ0gsQ0F4S0QiLCJmaWxlIjoiZ2VuZXJhdGVkLmpzIiwic291cmNlUm9vdCI6IiIsInNvdXJjZXNDb250ZW50IjpbIihmdW5jdGlvbiBlKHQsbixyKXtmdW5jdGlvbiBzKG8sdSl7aWYoIW5bb10pe2lmKCF0W29dKXt2YXIgYT10eXBlb2YgcmVxdWlyZT09XCJmdW5jdGlvblwiJiZyZXF1aXJlO2lmKCF1JiZhKXJldHVybiBhKG8sITApO2lmKGkpcmV0dXJuIGkobywhMCk7dmFyIGY9bmV3IEVycm9yKFwiQ2Fubm90IGZpbmQgbW9kdWxlICdcIitvK1wiJ1wiKTt0aHJvdyBmLmNvZGU9XCJNT0RVTEVfTk9UX0ZPVU5EXCIsZn12YXIgbD1uW29dPXtleHBvcnRzOnt9fTt0W29dWzBdLmNhbGwobC5leHBvcnRzLGZ1bmN0aW9uKGUpe3ZhciBuPXRbb11bMV1bZV07cmV0dXJuIHMobj9uOmUpfSxsLGwuZXhwb3J0cyxlLHQsbixyKX1yZXR1cm4gbltvXS5leHBvcnRzfXZhciBpPXR5cGVvZiByZXF1aXJlPT1cImZ1bmN0aW9uXCImJnJlcXVpcmU7Zm9yKHZhciBvPTA7bzxyLmxlbmd0aDtvKyspcyhyW29dKTtyZXR1cm4gc30pIiwiXCJ1c2Ugc3RyaWN0XCI7XG4kKGRvY3VtZW50KS5yZWFkeShmdW5jdGlvbigpIHtcblxuICAgIHdpbmRvdy5zZXRUaW1lb3V0KGZ1bmN0aW9uKCkge1xuICAgICAgICAkKCcuYWxlcnQtc3VjY2VzcycpLmZhZGVUbyg1MDAsIDApLnNsaWRlVXAoNTAwLCBmdW5jdGlvbigpIHtcbiAgICAgICAgICAgICQodGhpcykucmVtb3ZlKCk7XG4gICAgICAgIH0pO1xuICAgIH0sIDMwMDApO1xuXG4gICAgJCgnLmRlbGV0ZS1jb25maXJtJykub24oJ3N1Ym1pdCcsIGZ1bmN0aW9uKCkge1xuICAgICAgICByZXR1cm4gY29uZmlybSgnQXJlIHlvdSBzdXJlIHlvdSB3YW50IHRvIGRlbGV0ZSB0aGlzPycpO1xuICAgIH0pO1xuXG4gICAgJChcIi5vcHVzLXNyY1wiKS51bnZlaWwoKTtcblxuICAgICQoJyNwcmV2aWV3JykuY2xpY2soZnVuY3Rpb24oKSB7XG4gICAgICAgICQoJyNmdWxsdmlldycpLnNob3coKS51bnZlaWwoKTtcbiAgICAgICAgJCgnLmZ1bGx2aWV3LWJveCcpLnNob3coKTtcbiAgICAgICAgJCh0aGlzKS50b2dnbGUoKTtcbiAgICB9KTtcblxuICAgICQoJyNmdWxsdmlldycpLmNsaWNrKGZ1bmN0aW9uKCkge1xuICAgICAgICAkKHRoaXMpLnRvZ2dsZSgpO1xuICAgICAgICAkKCcuZnVsbHZpZXctYm94JykudG9nZ2xlKCk7XG4gICAgICAgICQoJyNwcmV2aWV3JykudG9nZ2xlKCk7XG4gICAgfSk7XG5cbiAgICAkKCcjc2VsZWN0QWxsT3B1cycpLmNsaWNrKGZ1bmN0aW9uKCkge1xuICAgICAgICB2YXIgY2hlY2tib3ggPSAkKCcub3B1cy1tZXNzYWdlLXNlbGVjdCcpO1xuICAgICAgICBjaGVja2JveC5wcm9wKCdjaGVja2VkJywgIWNoZWNrYm94LmlzKFwiOmNoZWNrZWRcIikpO1xuICAgIH0pO1xuXG5cbiAgICAvL3ZhciBudW0gPSAxNTA7IC8vbnVtYmVyIG9mIHBpeGVscyBiZWZvcmUgbW9kaWZ5aW5nIHN0eWxlc1xuICAgIHZhciBuYXZwb3MgPSAkKCcudG9wLWhlYWRlcicpLm9mZnNldCgpO1xuICAgIHZhciBzb3J0QnV0dG9uID0gJCgnLmJ1dHRvbi1jb250YWluZXInKTtcbiAgICB2YXIgc29ydEJ1dHRvblBvcyA9IHNvcnRCdXR0b24ub2Zmc2V0KCk7XG5cbiAgICAkKHdpbmRvdykuYmluZCgnc2Nyb2xsJywgZnVuY3Rpb24oKSB7XG5cbiAgICAgICAgdmFyIHggPSAkKHRoaXMpLnNjcm9sbFRvcCgpO1xuICAgICAgICAkKCcjaGVhZGVyLWJhY2tncm91bmQnKS5jc3MoJ2JhY2tncm91bmQtcG9zaXRpb24nLCAnMTAwJSAnICsgcGFyc2VJbnQoLXgpICsgJ3B4JyArICcsIDAlICcgKyBwYXJzZUludCgteCkgKyAncHgsIGNlbnRlciB0b3AnKTtcblxuICAgICAgICBpZiAoJCh3aW5kb3cpLnNjcm9sbFRvcCgpID4gbmF2cG9zLnRvcCkge1xuICAgICAgICAgICAgJCgnLnRvcC1oZWFkZXInKS5hZGRDbGFzcygnZml4ZWQnKTtcbiAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAgICQoJy50b3AtaGVhZGVyJykucmVtb3ZlQ2xhc3MoJ2ZpeGVkJyk7XG4gICAgICAgIH1cblxuICAgICAgICBpZiAoJCh3aW5kb3cpLnNjcm9sbFRvcCgpID4gc29ydEJ1dHRvblBvcy50b3AgLSBwYXJzZUludCgyICogc29ydEJ1dHRvbi5oZWlnaHQoKSkpIHtcbiAgICAgICAgICAgICQoJy5idXR0b24tY29udGFpbmVyJykuYWRkQ2xhc3MoJ2ZpeGVkLWJ1dHRvbnMnKTtcbiAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAgICQoJy5idXR0b24tY29udGFpbmVyJykucmVtb3ZlQ2xhc3MoJ2ZpeGVkLWJ1dHRvbnMnKTtcbiAgICAgICAgfVxuICAgIH0pO1xuXG4gICAgdmFyIGltYWdlID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ2F2YXRhci1jcm9wcGVyJyk7XG5cbiAgICBmdW5jdGlvbiByZWFkVVJMKGlucHV0KSB7XG5cbiAgICAgICAgaWYgKGlucHV0LmZpbGVzICYmIGlucHV0LmZpbGVzWzBdKSB7XG4gICAgICAgICAgICBjb25zb2xlLmxvZygnUmVhZGluZyBmaWxlJyk7XG4gICAgICAgICAgICB2YXIgcmVhZGVyID0gbmV3IEZpbGVSZWFkZXIoKTtcblxuICAgICAgICAgICAgcmVhZGVyLnJlYWRBc0RhdGFVUkwoaW5wdXQuZmlsZXNbMF0pO1xuXG4gICAgICAgICAgICByZWFkZXIub25sb2FkID0gZnVuY3Rpb24oZSkge1xuICAgICAgICAgICAgICAgIGF2YXRhckNyb3BwZXIucmVwbGFjZShlLnRhcmdldC5yZXN1bHQpO1xuICAgICAgICAgICAgfTtcbiAgICAgICAgfVxuICAgIH1cblxuICAgIGZ1bmN0aW9uIHJlYWRGaWxlKGlucHV0LCBpbWdFbGVtZW50KSB7XG5cbiAgICAgICAgaWYgKGlucHV0LmZpbGVzICYmIGlucHV0LmZpbGVzWzBdKSB7XG4gICAgICAgICAgICBjb25zb2xlLmxvZygnUmVhZGluZyBmaWxlJyk7XG4gICAgICAgICAgICB2YXIgcmVhZGVyID0gbmV3IEZpbGVSZWFkZXIoKTtcblxuICAgICAgICAgICAgcmVhZGVyLnJlYWRBc0RhdGFVUkwoaW5wdXQuZmlsZXNbMF0pO1xuXG4gICAgICAgICAgICByZWFkZXIub25sb2FkID0gZnVuY3Rpb24oZSkge1xuICAgICAgICAgICAgICAgICQoaW1nRWxlbWVudCkuYXR0cignc3JjJywgZS50YXJnZXQucmVzdWx0KTtcbiAgICAgICAgICAgIH07XG4gICAgICAgIH1cbiAgICB9XG5cbiAgICB2YXIgJHJlcGx5VG9nZ2xlID0gJCgnLnJlcGx5LXRvZ2dsZScpO1xuXG4gICAgJHJlcGx5VG9nZ2xlLmNsaWNrKGZ1bmN0aW9uKCkge1xuICAgICAgICAkKHRoaXMpLmNoaWxkcmVuKCkuc2hvdygpO1xuICAgICAgICAkKHRoaXMpLmNoaWxkcmVuKCcucmVwbHktYnRuJykuaGlkZSgpO1xuICAgIH0pO1xuXG5cbiAgICB2YXIgYW5jaG9yID0gd2luZG93LmxvY2F0aW9uLmhhc2g7XG4gICAgaWYgKGFuY2hvciA9PSAnI3JlcGx5VG9wJykge1xuICAgICAgICAkKGFuY2hvcikuY2hpbGRyZW4oJy5yZXBseS1mb3JtJykuc2hvdygpO1xuICAgICAgICAkKGFuY2hvcikuY2hpbGRyZW4oJy5yZXBseS1idG4nKS5oaWRlKCk7XG4gICAgfVxuXG5cbiAgICAkKCcjYXZhdGFyLWZpbGUnKS5jaGFuZ2UoZnVuY3Rpb24oKSB7XG4gICAgICAgIHJlYWRVUkwodGhpcyk7XG4gICAgfSk7XG5cbiAgICAvLyAkKCcub3B1cy1vdmVybGF5Jykub24oJ2hvdmVyJywgZnVuY3Rpb24oKSB7XG4gICAgLy8gICAgIGNvbnNvbGUubG9nKCdvdmVybGF5IHRyaWdnZXInKTtcbiAgICAvLyAgICAgJCh0aGlzKS5mYWRlSW4oMzAwKTtcbiAgICAvLyB9LCBmdW5jdGlvbigpIHtcbiAgICAvLyAgICAgJCh0aGlzKS5mYWRlT3V0KDMwMCk7XG4gICAgLy8gfSk7XG5cbiAgICAkKCcjaW1hZ2UnKS5jaGFuZ2UoZnVuY3Rpb24oKSB7XG4gICAgICAgIHJlYWRGaWxlKHRoaXMsICcjcHJldmlldy11cGxvYWQnKTtcbiAgICAgICAgcmVhZEZpbGUodGhpcywgJyNwcmV2aWV3LWVkaXQnKTtcbiAgICAgICAgJCgnI3ByZXZpZXctdXBsb2FkJykuc2hvdygpO1xuICAgICAgICAkKCdkaXYucHJldmlldy1jb250YWluZXInKS5zaG93KCk7XG4gICAgfSk7XG5cbiAgICB0cnkge1xuICAgICAgICB2YXIgYXZhdGFyQ3JvcHBlciA9IG5ldyBDcm9wcGVyKGltYWdlLCB7XG4gICAgICAgICAgICBhc3BlY3RSYXRpbzogMSxcbiAgICAgICAgICAgIGNyb3A6IGZ1bmN0aW9uKGUpIHtcbiAgICAgICAgICAgICAgICAvLyBjb25zb2xlLmxvZyhlLmRldGFpbC54KTtcbiAgICAgICAgICAgICAgICAvLyBjb25zb2xlLmxvZyhlLmRldGFpbC55KTtcbiAgICAgICAgICAgICAgICAvLyBjb25zb2xlLmxvZyhlLmRldGFpbC53aWR0aCk7XG4gICAgICAgICAgICAgICAgLy8gY29uc29sZS5sb2coZS5kZXRhaWwuaGVpZ2h0KTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgfSk7XG4gICAgfSBjYXRjaCAoZSkge31cblxuICAgICQoJy5jcm9wLXN1Ym1pdCcpLm9uKCdjbGljaycsIGZ1bmN0aW9uKGUpIHtcbiAgICAgICAgY29uc29sZS5sb2coJ0Nyb3BwaW5nIGF2YXRhcicpO1xuICAgICAgICB2YXIgZm9ybU9iaiA9ICQoJyNhdmF0YXItZm9ybScpO1xuICAgICAgICB2YXIgZm9ybVVSTCA9IGZvcm1PYmouYXR0cihcImFjdGlvblwiKTtcbiAgICAgICAgdmFyIHRva2VuID0gJCgnaW5wdXRbbmFtZT1fdG9rZW5dJyk7XG5cbiAgICAgICAgY29uc29sZS5sb2coZm9ybVVSTCk7XG4gICAgICAgIGF2YXRhckNyb3BwZXIuZ2V0Q3JvcHBlZENhbnZhcygpLnRvQmxvYihmdW5jdGlvbihibG9iKSB7XG4gICAgICAgICAgICB2YXIgZm9ybURhdGEgPSBuZXcgRm9ybURhdGEoKTtcblxuXG4gICAgICAgICAgICBmb3JtRGF0YS5hcHBlbmQoJ2ltYWdlJywgYmxvYik7XG4gICAgICAgICAgICBjb25zb2xlLmxvZyhmb3JtRGF0YSk7XG5cbiAgICAgICAgICAgIC8vIFVzZSBgalF1ZXJ5LmFqYXhgIG1ldGhvZFxuICAgICAgICAgICAgJC5hamF4KHtcbiAgICAgICAgICAgICAgICB1cmw6IGZvcm1VUkwsXG4gICAgICAgICAgICAgICAgbWV0aG9kOiBcIlBPU1RcIixcbiAgICAgICAgICAgICAgICBkYXRhOiBmb3JtRGF0YSxcbiAgICAgICAgICAgICAgICBoZWFkZXJzOiB7XG4gICAgICAgICAgICAgICAgICAgICdYLUNTUkYtVE9LRU4nOiB0b2tlbi52YWwoKVxuICAgICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICAgICAgcHJvY2Vzc0RhdGE6IGZhbHNlLFxuICAgICAgICAgICAgICAgIGNvbnRlbnRUeXBlOiBmYWxzZSxcbiAgICAgICAgICAgICAgICBzdWNjZXNzOiBmdW5jdGlvbigpIHtcbiAgICAgICAgICAgICAgICAgICAgY29uc29sZS5sb2coJ1VwbG9hZCBzdWNjZXNzJyk7XG4gICAgICAgICAgICAgICAgfSxcbiAgICAgICAgICAgICAgICBlcnJvcjogZnVuY3Rpb24oKSB7XG4gICAgICAgICAgICAgICAgICAgIGNvbnNvbGUubG9nKCdVcGxvYWQgZXJyb3InKTtcbiAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICB9KTtcblxuICAgICAgICB9KTtcbiAgICAgICAgZS5wcmV2ZW50RGVmYXVsdCgpO1xuICAgICAgICB3aW5kb3cuc2V0VGltZW91dChmdW5jdGlvbigpIHtcbiAgICAgICAgICAgIGxvY2F0aW9uLnJlbG9hZCgpO1xuICAgICAgICB9LCAyMDAwKVxuICAgIH0pO1xufSk7Il19
