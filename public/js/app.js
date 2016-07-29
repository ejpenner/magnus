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
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIi4uLy4uLy5ucG0tbG9jYWwvZ2FsbGVyeS1hcHAvbm9kZV9tb2R1bGVzL2Jyb3dzZXItcGFjay9fcHJlbHVkZS5qcyIsInJlc291cmNlcy9hc3NldHMvanMvYXBwLmpzIl0sIm5hbWVzIjpbXSwibWFwcGluZ3MiOiJBQUFBO0FDQUE7O0FBQ0EsRUFBRSxRQUFGLEVBQVksS0FBWixDQUFrQixZQUFXOztBQUV6QixRQUFJLFdBQVcsRUFBRSxXQUFGLENBQWY7QUFDQSxRQUFJLFVBQVUsRUFBRSxVQUFGLENBQWQ7QUFDQSxRQUFJLFVBQVUsT0FBTyxRQUFQLENBQWdCLElBQTlCO0FBQ0EsUUFBSSxZQUFZLEVBQUUsYUFBRixDQUFoQjtBQUNBLFFBQUksU0FBUyxVQUFVLE1BQVYsRUFBYjtBQUNBLFFBQUksYUFBYSxFQUFFLG1CQUFGLENBQWpCO0FBQ0EsUUFBSSxnQkFBZ0IsV0FBVyxNQUFYLEVBQXBCO0FBQ0EsUUFBSSxRQUFRLFNBQVMsY0FBVCxDQUF3QixnQkFBeEIsQ0FBWjs7QUFFQSxXQUFPLFVBQVAsQ0FBa0IsWUFBVztBQUN6QixVQUFFLGdCQUFGLEVBQW9CLE1BQXBCLENBQTJCLEdBQTNCLEVBQWdDLENBQWhDLEVBQW1DLE9BQW5DLENBQTJDLEdBQTNDLEVBQWdELFlBQVc7QUFDdkQsY0FBRSxJQUFGLEVBQVEsTUFBUjtBQUNILFNBRkQ7QUFHSCxLQUpELEVBSUcsSUFKSDs7QUFNQSxNQUFFLGlCQUFGLEVBQXFCLEVBQXJCLENBQXdCLFFBQXhCLEVBQWtDLFlBQVc7QUFDekMsZUFBTyxRQUFRLHVDQUFSLENBQVA7QUFDSCxLQUZEOztBQUlBLFlBQVEsS0FBUixDQUFjLFlBQVc7QUFDckIsVUFBRSxlQUFGLEVBQW1CLElBQW5COztBQUVBLFVBQUUsSUFBRixFQUFRLE1BQVI7QUFDQSxpQkFBUyxJQUFULEdBQWdCLE1BQWhCO0FBQ0gsS0FMRDs7QUFPQSxhQUFTLEtBQVQsQ0FBZSxZQUFXO0FBQ3RCLFVBQUUsSUFBRixFQUFRLE1BQVI7O0FBRUEsVUFB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USxNQUZMO0FBR0gsc0JBQU0sUUFISDtBQUlILHlCQUFTO0FBQ0wsb0NBQWdCLE1BQU0sR0FBTjtBQURYLGlCQUpOO0FBT0gsNkJBQWEsS0FQVjtBQVFILDZCQUFhLEtBUlY7QUFTSCx5QkFBUyxZQUFXO0FBQ2hCLDRCQUFRLEdBQVIsQ0FBWSxnQkFBWjtBQUNILGlCQVhFO0FBWUgsdUJBQU8sWUFBVztBQUNkLDRCQUFRLEdBQVIsQ0FBWSxjQUFaO0FBQ0g7QUFkRSxhQUFQO0FBaUJILFNBekJEOztBQTJCQSxVQUFFLGNBQUY7O0FBRUEsZUFBTyxVQUFQLENBQWtCLFlBQVc7QUFDekIscUJBQVMsTUFBVDtBQUNILFNBRkQsRUFFRyxJQUZIO0FBR0gsS0F2Q0Q7QUF3Q0gsQ0FyTEQiLCJmaWxlIjoiZ2VuZXJhdGVkLmpzIiwic291cmNlUm9vdCI6IiIsInNvdXJjZXNDb250ZW50IjpbIihmdW5jdGlvbiBlKHQsbixyKXtmdW5jdGlvbiBzKG8sdSl7aWYoIW5bb10pe2lmKCF0W29dKXt2YXIgYT10eXBlb2YgcmVxdWlyZT09XCJmdW5jdGlvblwiJiZyZXF1aXJlO2lmKCF1JiZhKXJldHVybiBhKG8sITApO2lmKGkpcmV0dXJuIGkobywhMCk7dmFyIGY9bmV3IEVycm9yKFwiQ2Fubm90IGZpbmQgbW9kdWxlICdcIitvK1wiJ1wiKTt0aHJvdyBmLmNvZGU9XCJNT0RVTEVfTk9UX0ZPVU5EXCIsZn12YXIgbD1uW29dPXtleHBvcnRzOnt9fTt0W29dWzBdLmNhbGwobC5leHBvcnRzLGZ1bmN0aW9uKGUpe3ZhciBuPXRbb11bMV1bZV07cmV0dXJuIHMobj9uOmUpfSxsLGwuZXhwb3J0cyxlLHQsbixyKX1yZXR1cm4gbltvXS5leHBvcnRzfXZhciBpPXR5cGVvZiByZXF1aXJlPT1cImZ1bmN0aW9uXCImJnJlcXVpcmU7Zm9yKHZhciBvPTA7bzxyLmxlbmd0aDtvKyspcyhyW29dKTtyZXR1cm4gc30pIiwiXCJ1c2Ugc3RyaWN0XCI7XG4kKGRvY3VtZW50KS5yZWFkeShmdW5jdGlvbigpIHtcblxuICAgIHZhciBmdWxsdmlldyA9ICQoJyNmdWxsdmlldycpO1xuICAgIHZhciBwcmV2aWV3ID0gJCgnI3ByZXZpZXcnKTtcbiAgICB2YXIgaGFzaFZhbCA9IHdpbmRvdy5sb2NhdGlvbi5oYXNoO1xuICAgIHZhciB0b3BIZWFkZXIgPSAkKCcudG9wLWhlYWRlcicpO1xuICAgIHZhciBuYXZwb3MgPSB0b3BIZWFkZXIub2Zmc2V0KCk7XG4gICAgdmFyIHNvcnRCdXR0b24gPSAkKCcuYnV0dG9uLWNvbnRhaW5lcicpO1xuICAgIHZhciBzb3J0QnV0dG9uUG9zID0gc29ydEJ1dHRvbi5vZmZzZXQoKTtcbiAgICB2YXIgaW1hZ2UgPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgnYXZhdGFyLWNyb3BwZXInKTtcblxuICAgIHdpbmRvdy5zZXRUaW1lb3V0KGZ1bmN0aW9uKCkge1xuICAgICAgICAkKCcuYWxlcnQtc3VjY2VzcycpLmZhZGVUbyg1MDAsIDApLnNsaWRlVXAoNTAwLCBmdW5jdGlvbigpIHtcbiAgICAgICAgICAgICQodGhpcykucmVtb3ZlKCk7XG4gICAgICAgIH0pO1xuICAgIH0sIDMwMDApO1xuXG4gICAgJCgnLmRlbGV0ZS1jb25maXJtJykub24oJ3N1Ym1pdCcsIGZ1bmN0aW9uKCkge1xuICAgICAgICByZXR1cm4gY29uZmlybSgnQXJlIHlvdSBzdXJlIHlvdSB3YW50IHRvIGRlbGV0ZSB0aGlzPycpO1xuICAgIH0pO1xuXG4gICAgcHJldmlldy5jbGljayhmdW5jdGlvbigpIHtcbiAgICAgICAgJCgnLmZ1bGx2aWV3LWJveCcpLnNob3coKTtcbiAgICAgICAgLy8kKCcjb3B1cy1pbWFnZScpLmNzcygnd2lkdGgnLCAnMTAwJScpO1xuICAgICAgICAkKHRoaXMpLnRvZ2dsZSgpO1xuICAgICAgICBmdWxsdmlldy5zaG93KCkudW52ZWlsKCk7XG4gICAgfSk7XG5cbiAgICBmdWxsdmlldy5jbGljayhmdW5jdGlvbigpIHtcbiAgICAgICAgJCh0aGlzKS50b2dnbGUoKTtcbiAgICAgICAgLy8kKCcjb3B1cy1pbWFnZScpLmNzcygnd2lkdGgnLCAnODAlJyk7XG4gICAgICAgICQoJy5mdWxsdmlldy1ib3gnKS50b2dnbGUoKTtcbiAgICAgICAgcHJldmlldy50b2dnbGUoKTtcbiAgICB9KTtcblxuICAgIGlmIChoYXNoVmFsLmluZGV4T2YoJ2Z1bGwnKSAhPSAtMSkge1xuICAgICAgICBwcmV2aWV3LnRvZ2dsZSgpO1xuICAgICAgICAkKCcuZnVsbHZpZXctYm94Jykuc2hvdygpO1xuICAgICAgICBmdWxsdmlldy5zaG93KCkudW52ZWlsKCk7XG4gICAgfVxuXG4gICAgJCgnI3NlbGVjdEFsbE9wdXMnKS5jbGljayhmdW5jdGlvbigpIHtcbiAgICAgICAgdmFyIGNoZWNrYm94ID0gJCgnLm9wdXMtbWVzc2FnZS1zZWxlY3QnKTtcbiAgICAgICAgY2hlY2tib3gucHJvcCgnY2hlY2tlZCcsICFjaGVja2JveC5pcyhcIjpjaGVja2VkXCIpKTtcbiAgICB9KTtcblxuXG4gICAgLy92YXIgbnVtID0gMTUwOyAvL251bWJlciBvZiBwaXhlbHMgYmVmb3JlIG1vZGlmeWluZyBzdHlsZXNcblxuICAgICQod2luZG93KS5iaW5kKCdzY3JvbGwnLCBmdW5jdGlvbigpIHtcblxuICAgICAgICB2YXIgeCA9ICQodGhpcykuc2Nyb2xsVG9wKCk7XG4gICAgICAgICQoJyNoZWFkZXItYmFja2dyb3VuZCcpLmNzcygnYmFja2dyb3VuZC1wb3NpdGlvbicsICcxMDAlICcgKyBwYXJzZUludCgteCkgKyAncHgnICsgJywgMCUgJyArIHBhcnNlSW50KC14KSArICdweCwgY2VudGVyIHRvcCcpO1xuXG4gICAgICAgIGlmICgkKHdpbmRvdykuc2Nyb2xsVG9wKCkgPiBuYXZwb3MudG9wKSB7XG4gICAgICAgICAgICB0b3BIZWFkZXIuYWRkQ2xhc3MoJ2ZpeGVkJyk7XG4gICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgICB0b3BIZWFkZXIucmVtb3ZlQ2xhc3MoJ2ZpeGVkJyk7XG4gICAgICAgIH1cbiAgICAgICAgdHJ5IHtcbiAgICAgICAgICAgIGlmICgkKHdpbmRvdykuc2Nyb2xsVG9wKCkgPiBzb3J0QnV0dG9uUG9zLnRvcCAtIHBhcnNlSW50KDIgKiBzb3J0QnV0dG9uLmhlaWdodCgpKSkge1xuICAgICAgICAgICAgICAgICQoJy5idXR0b24tY29udGFpbmVyJykuYWRkQ2xhc3MoJ2ZpeGVkLWJ1dHRvbnMnKTtcbiAgICAgICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgICAgICAgJCgnLmJ1dHRvbi1jb250YWluZXInKS5yZW1vdmVDbGFzcygnZml4ZWQtYnV0dG9ucycpO1xuICAgICAgICAgICAgfVxuICAgICAgICB9IGNhdGNoIChlKSB7fVxuICAgIH0pO1xuXG4gICAgZnVuY3Rpb24gcmVhZFVSTChpbnB1dCkge1xuXG4gICAgICAgIGlmIChpbnB1dC5maWxlcyAmJiBpbnB1dC5maWxlc1swXSkge1xuICAgICAgICAgICAgY29uc29sZS5sb2coJ1JlYWRpbmcgZmlsZScpO1xuICAgICAgICAgICAgdmFyIHJlYWRlciA9IG5ldyBGaWxlUmVhZGVyKCk7XG5cbiAgICAgICAgICAgIHJlYWRlci5yZWFkQXNEYXRhVVJMKGlucHV0LmZpbGVzWzBdKTtcblxuICAgICAgICAgICAgcmVhZGVyLm9ubG9hZCA9IGZ1bmN0aW9uKGUpIHtcbiAgICAgICAgICAgICAgICBhdmF0YXJDcm9wcGVyLnJlcGxhY2UoZS50YXJnZXQucmVzdWx0KTtcbiAgICAgICAgICAgIH07XG4gICAgICAgIH1cbiAgICB9XG5cbiAgICBmdW5jdGlvbiByZWFkRmlsZShpbnB1dCwgaW1nRWxlbWVudCkge1xuXG4gICAgICAgIGlmIChpbnB1dC5maWxlcyAmJiBpbnB1dC5maWxlc1swXSkge1xuICAgICAgICAgICAgY29uc29sZS5sb2coJ1JlYWRpbmcgZmlsZScpO1xuICAgICAgICAgICAgdmFyIHJlYWRlciA9IG5ldyBGaWxlUmVhZGVyKCk7XG5cbiAgICAgICAgICAgIHJlYWRlci5yZWFkQXNEYXRhVVJMKGlucHV0LmZpbGVzWzBdKTtcblxuICAgICAgICAgICAgcmVhZGVyLm9ubG9hZCA9IGZ1bmN0aW9uKGUpIHtcbiAgICAgICAgICAgICAgICAkKGltZ0VsZW1lbnQpLmF0dHIoJ3NyYycsIGUudGFyZ2V0LnJlc3VsdCk7XG4gICAgICAgICAgICB9O1xuICAgICAgICB9XG4gICAgfVxuXG4gICAgdmFyICRyZXBseVRvZ2dsZSA9ICQoJy5yZXBseS10b2dnbGUnKTtcblxuICAgICRyZXBseVRvZ2dsZS5jbGljayhmdW5jdGlvbigpIHtcbiAgICAgICAgJCh0aGlzKS5jaGlsZHJlbigpLnNob3coKTtcbiAgICAgICAgJCh0aGlzKS5jaGlsZHJlbignLnJlcGx5LWJ0bicpLmhpZGUoKTtcbiAgICB9KTtcblxuXG4gICAgdmFyIGFuY2hvciA9IHdpbmRvdy5sb2NhdGlvbi5oYXNoO1xuICAgIGlmIChhbmNob3IgPT0gJyNyZXBseVRvcCcpIHtcbiAgICAgICAgJChhbmNob3IpLmNoaWxkcmVuKCcucmVwbHktZm9ybScpLnNob3coKTtcbiAgICAgICAgJChhbmNob3IpLmNoaWxkcmVuKCcucmVwbHktYnRuJykuaGlkZSgpO1xuICAgIH1cblxuXG4gICAgJCgnI2F2YXRhci1maWxlJykuY2hhbmdlKGZ1bmN0aW9uKCkge1xuICAgICAgICByZWFkVVJMKHRoaXMpO1xuICAgIH0pO1xuXG4gICAgLy8gJCgnLm9wdXMtb3ZlcmxheScpLm9uKCdob3ZlcicsIGZ1bmN0aW9uKCkge1xuICAgIC8vICAgICBjb25zb2xlLmxvZygnb3ZlcmxheSB0cmlnZ2VyJyk7XG4gICAgLy8gICAgICQodGhpcykuZmFkZUluKDMwMCk7XG4gICAgLy8gfSwgZnVuY3Rpb24oKSB7XG4gICAgLy8gICAgICQodGhpcykuZmFkZU91dCgzMDApO1xuICAgIC8vIH0pO1xuXG4gICAgJCgnI2ltYWdlJykuY2hhbmdlKGZ1bmN0aW9uKCkge1xuICAgICAgICByZWFkRmlsZSh0aGlzLCAnI3ByZXZpZXctdXBsb2FkJyk7XG4gICAgICAgIHJlYWRGaWxlKHRoaXMsICcjcHJldmlldy1lZGl0Jyk7XG4gICAgICAgICQoJyNwcmV2aWV3LXVwbG9hZCcpLnNob3coKTtcbiAgICAgICAgJCgnZGl2LnByZXZpZXctY29udGFpbmVyJykuc2hvdygpO1xuICAgIH0pO1xuXG4gICAgdHJ5IHtcbiAgICAgICAgdmFyIGF2YXRhckNyb3BwZXIgPSBuZXcgQ3JvcHBlcihpbWFnZSwge1xuICAgICAgICAgICAgYXNwZWN0UmF0aW86IDEsXG4gICAgICAgICAgICBjcm9wOiBmdW5jdGlvbihlKSB7XG4gICAgICAgICAgICAgICAgLy8gY29uc29sZS5sb2coZS5kZXRhaWwueCk7XG4gICAgICAgICAgICAgICAgLy8gY29uc29sZS5sb2coZS5kZXRhaWwueSk7XG4gICAgICAgICAgICAgICAgLy8gY29uc29sZS5sb2coZS5kZXRhaWwud2lkdGgpO1xuICAgICAgICAgICAgICAgIC8vIGNvbnNvbGUubG9nKGUuZGV0YWlsLmhlaWdodCk7XG4gICAgICAgICAgICB9XG4gICAgICAgIH0pO1xuICAgIH0gY2F0Y2ggKGUpIHt9XG5cbiAgICAkKCcuY3JvcC1zdWJtaXQnKS5vbignY2xpY2snLCBmdW5jdGlvbihlKSB7XG4gICAgICAgIGNvbnNvbGUubG9nKCdDcm9wcGluZyBhdmF0YXInKTtcbiAgICAgICAgdmFyIGZvcm1PYmogPSAkKCcjYXZhdGFyLWZvcm0nKTtcbiAgICAgICAgdmFyIGZvcm1VUkwgPSBmb3JtT2JqLmF0dHIoXCJhY3Rpb25cIik7XG4gICAgICAgIHZhciB0b2tlbiA9ICQoJ2lucHV0W25hbWU9X3Rva2VuXScpO1xuXG4gICAgICAgIGNvbnNvbGUubG9nKGZvcm1VUkwpO1xuICAgICAgICBhdmF0YXJDcm9wcGVyLmdldENyb3BwZWRDYW52YXMoKS50b0Jsb2IoZnVuY3Rpb24oYmxvYikge1xuICAgICAgICAgICAgdmFyIGZvcm1EYXRhID0gbmV3IEZvcm1EYXRhKCk7XG5cblxuICAgICAgICAgICAgZm9ybURhdGEuYXBwZW5kKCdpbWFnZScsIGJsb2IpO1xuICAgICAgICAgICAgY29uc29sZS5sb2coZm9ybURhdGEpO1xuXG4gICAgICAgICAgICAvLyBVc2UgYGpRdWVyeS5hamF4YCBtZXRob2RcbiAgICAgICAgICAgICQuYWpheCh7XG4gICAgICAgICAgICAgICAgdXJsOiBmb3JtVVJMLFxuICAgICAgICAgICAgICAgIG1ldGhvZDogXCJQT1NUXCIsXG4gICAgICAgICAgICAgICAgZGF0YTogZm9ybURhdGEsXG4gICAgICAgICAgICAgICAgaGVhZGVyczoge1xuICAgICAgICAgICAgICAgICAgICAnWC1DU1JGLVRPS0VOJzogdG9rZW4udmFsKClcbiAgICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgICAgIHByb2Nlc3NEYXRhOiBmYWxzZSxcbiAgICAgICAgICAgICAgICBjb250ZW50VHlwZTogZmFsc2UsXG4gICAgICAgICAgICAgICAgc3VjY2VzczogZnVuY3Rpb24oKSB7XG4gICAgICAgICAgICAgICAgICAgIGNvbnNvbGUubG9nKCdVcGxvYWQgc3VjY2VzcycpO1xuICAgICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICAgICAgZXJyb3I6IGZ1bmN0aW9uKCkge1xuICAgICAgICAgICAgICAgICAgICBjb25zb2xlLmxvZygnVXBsb2FkIGVycm9yJyk7XG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgfSk7XG5cbiAgICAgICAgfSk7XG5cbiAgICAgICAgZS5wcmV2ZW50RGVmYXVsdCgpO1xuXG4gICAgICAgIHdpbmRvdy5zZXRUaW1lb3V0KGZ1bmN0aW9uKCkge1xuICAgICAgICAgICAgbG9jYXRpb24ucmVsb2FkKCk7XG4gICAgICAgIH0sIDIwMDApXG4gICAgfSk7XG59KTsiXX0=
