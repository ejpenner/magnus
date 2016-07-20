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

    // $(".opus-src").unveil();

    $('#preview').click(function () {
        $('.fullview-box').show();
        $('#opus-image').css('width', '100%');
        $(this).toggle();
        $('#fullview').show().unveil();
    });

    $('#fullview').click(function () {
        $(this).toggle();
        $('#opus-image').css('width', '80%');
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
        try {
            if ($(window).scrollTop() > sortButtonPos.top - parseInt(2 * sortButton.height())) {
                $('.button-container').addClass('fixed-buttons');
            } else {
                $('.button-container').removeClass('fixed-buttons');
            }
        } catch (e) {}
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
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIi4uLy4uLy5ucG0tbG9jYWwvZ2FsbGVyeS1hcHAvbm9kZV9tb2R1bGVzL2Jyb3dzZXJpZnkvbm9kZV9tb2R1bGVzL2Jyb3dzZXItcGFjay9fcHJlbHVkZS5qcyIsInJlc291cmNlcy9hc3NldHMvanMvYXBwLmpzIl0sIm5hbWVzIjpbXSwibWFwcGluZ3MiOiJBQUFBO0FDQUE7O0FBQ0EsRUFBRSxRQUFGLEVBQVksS0FBWixDQUFrQixZQUFXOztBQUV6QixXQUFPLFVBQVAsQ0FBa0IsWUFBVztBQUN6QixVQUFFLGdCQUFGLEVBQW9CLE1BQXBCLENBQTJCLEdBQTNCLEVBQWdDLENBQWhDLEVBQW1DLE9BQW5DLENBQTJDLEdBQTNDLEVBQWdELFlBQVc7QUFDdkQsY0FBRSxJQUFGLEVBQVEsTUFBUjtBQUNILFNBRkQ7QUFHSCxLQUpELEVBSUcsSUFKSDs7QUFNQSxNQUFFLGlCQUFGLEVBQXFCLEVBQXJCLENBQXdCLFFBQXhCLEVBQWtDLFlBQVc7QUFDekMsZUFBTyxRQUFRLHVDQUFSLENBQVA7QUFDSCxLQUZEOzs7O0FBTUEsTUFBRSxVQUFGLEVBQWMsS0FBZCxDQUFvQixZQUFXO0FBQzNCLFVBQUUsZUFBRixFQUFtQixJQUFuQjtBQUNBLFVBQUUsYUFBRixFQUFpQixHQUFqQixDQUFxQixPQUFyQixFQUE4QixNQUE5QjtBQUNBLFVBQUUsSUFBRixFQUFRLE1BQVI7QUFDQSxVQUFFLFdBQUYsRUFBZSxJQUFmLEdBQXNCLE1BQXRCO0FBQ0gsS0FMRDs7QUFPQSxNQUFFLFdBQUYsRUFBZSxLQUFmLENBQXFCLFlBQVc7QUFDNUIsVUFBRSxJQUFGLEVBQVEsTUFBUjtBQUNBLFVBQUUsYUFBRixFQUFpQixHQUFqQixDQUFxQixPQUFyQixFQUE4QixLQUE5QjtBQUNBLFVBQUUsZUFBRixFQUFtQixNQUFuQjtBQUNBLFVBQUUsVUFBRixFQUFjLE1BQWQ7QUFDSCxLQUxEOztBQU9BLE1BQUUsZ0JBQUYsRUFBb0IsS0FBcEIsQ0FBMEIsWUFBVztBQUNqQyxZQUFJLFdBQVcs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aUJBSk47QUFPSCw2QkFBYSxLQVBWO0FBUUgsNkJBQWEsS0FSVjtBQVNILHlCQUFTLFlBQVc7QUFDaEIsNEJBQVEsR0FBUixDQUFZLGdCQUFaO0FBQ0gsaUJBWEU7QUFZSCx1QkFBTyxZQUFXO0FBQ2QsNEJBQVEsR0FBUixDQUFZLGNBQVo7QUFDSDtBQWRFLGFBQVA7QUFpQkgsU0F6QkQ7QUEwQkEsVUFBRSxjQUFGO0FBQ0EsZUFBTyxVQUFQLENBQWtCLFlBQVc7QUFDekIscUJBQVMsTUFBVDtBQUNILFNBRkQsRUFFRyxJQUZIO0FBR0gsS0FyQ0Q7QUFzQ0gsQ0EzS0QiLCJmaWxlIjoiZ2VuZXJhdGVkLmpzIiwic291cmNlUm9vdCI6IiIsInNvdXJjZXNDb250ZW50IjpbIihmdW5jdGlvbiBlKHQsbixyKXtmdW5jdGlvbiBzKG8sdSl7aWYoIW5bb10pe2lmKCF0W29dKXt2YXIgYT10eXBlb2YgcmVxdWlyZT09XCJmdW5jdGlvblwiJiZyZXF1aXJlO2lmKCF1JiZhKXJldHVybiBhKG8sITApO2lmKGkpcmV0dXJuIGkobywhMCk7dmFyIGY9bmV3IEVycm9yKFwiQ2Fubm90IGZpbmQgbW9kdWxlICdcIitvK1wiJ1wiKTt0aHJvdyBmLmNvZGU9XCJNT0RVTEVfTk9UX0ZPVU5EXCIsZn12YXIgbD1uW29dPXtleHBvcnRzOnt9fTt0W29dWzBdLmNhbGwobC5leHBvcnRzLGZ1bmN0aW9uKGUpe3ZhciBuPXRbb11bMV1bZV07cmV0dXJuIHMobj9uOmUpfSxsLGwuZXhwb3J0cyxlLHQsbixyKX1yZXR1cm4gbltvXS5leHBvcnRzfXZhciBpPXR5cGVvZiByZXF1aXJlPT1cImZ1bmN0aW9uXCImJnJlcXVpcmU7Zm9yKHZhciBvPTA7bzxyLmxlbmd0aDtvKyspcyhyW29dKTtyZXR1cm4gc30pIiwiXCJ1c2Ugc3RyaWN0XCI7XG4kKGRvY3VtZW50KS5yZWFkeShmdW5jdGlvbigpIHtcblxuICAgIHdpbmRvdy5zZXRUaW1lb3V0KGZ1bmN0aW9uKCkge1xuICAgICAgICAkKCcuYWxlcnQtc3VjY2VzcycpLmZhZGVUbyg1MDAsIDApLnNsaWRlVXAoNTAwLCBmdW5jdGlvbigpIHtcbiAgICAgICAgICAgICQodGhpcykucmVtb3ZlKCk7XG4gICAgICAgIH0pO1xuICAgIH0sIDMwMDApO1xuXG4gICAgJCgnLmRlbGV0ZS1jb25maXJtJykub24oJ3N1Ym1pdCcsIGZ1bmN0aW9uKCkge1xuICAgICAgICByZXR1cm4gY29uZmlybSgnQXJlIHlvdSBzdXJlIHlvdSB3YW50IHRvIGRlbGV0ZSB0aGlzPycpO1xuICAgIH0pO1xuXG4gICAgLy8gJChcIi5vcHVzLXNyY1wiKS51bnZlaWwoKTtcblxuICAgICQoJyNwcmV2aWV3JykuY2xpY2soZnVuY3Rpb24oKSB7XG4gICAgICAgICQoJy5mdWxsdmlldy1ib3gnKS5zaG93KCk7XG4gICAgICAgICQoJyNvcHVzLWltYWdlJykuY3NzKCd3aWR0aCcsICcxMDAlJyk7XG4gICAgICAgICQodGhpcykudG9nZ2xlKCk7XG4gICAgICAgICQoJyNmdWxsdmlldycpLnNob3coKS51bnZlaWwoKTtcbiAgICB9KTtcblxuICAgICQoJyNmdWxsdmlldycpLmNsaWNrKGZ1bmN0aW9uKCkge1xuICAgICAgICAkKHRoaXMpLnRvZ2dsZSgpO1xuICAgICAgICAkKCcjb3B1cy1pbWFnZScpLmNzcygnd2lkdGgnLCAnODAlJyk7XG4gICAgICAgICQoJy5mdWxsdmlldy1ib3gnKS50b2dnbGUoKTtcbiAgICAgICAgJCgnI3ByZXZpZXcnKS50b2dnbGUoKTtcbiAgICB9KTtcblxuICAgICQoJyNzZWxlY3RBbGxPcHVzJykuY2xpY2soZnVuY3Rpb24oKSB7XG4gICAgICAgIHZhciBjaGVja2JveCA9ICQoJy5vcHVzLW1lc3NhZ2Utc2VsZWN0Jyk7XG4gICAgICAgIGNoZWNrYm94LnByb3AoJ2NoZWNrZWQnLCAhY2hlY2tib3guaXMoXCI6Y2hlY2tlZFwiKSk7XG4gICAgfSk7XG5cblxuICAgIC8vdmFyIG51bSA9IDE1MDsgLy9udW1iZXIgb2YgcGl4ZWxzIGJlZm9yZSBtb2RpZnlpbmcgc3R5bGVzXG4gICAgdmFyIG5hdnBvcyA9ICQoJy50b3AtaGVhZGVyJykub2Zmc2V0KCk7XG4gICAgdmFyIHNvcnRCdXR0b24gPSAkKCcuYnV0dG9uLWNvbnRhaW5lcicpO1xuICAgIHZhciBzb3J0QnV0dG9uUG9zID0gc29ydEJ1dHRvbi5vZmZzZXQoKTtcblxuICAgICQod2luZG93KS5iaW5kKCdzY3JvbGwnLCBmdW5jdGlvbigpIHtcblxuICAgICAgICB2YXIgeCA9ICQodGhpcykuc2Nyb2xsVG9wKCk7XG4gICAgICAgICQoJyNoZWFkZXItYmFja2dyb3VuZCcpLmNzcygnYmFja2dyb3VuZC1wb3NpdGlvbicsICcxMDAlICcgKyBwYXJzZUludCgteCkgKyAncHgnICsgJywgMCUgJyArIHBhcnNlSW50KC14KSArICdweCwgY2VudGVyIHRvcCcpO1xuXG4gICAgICAgIGlmICgkKHdpbmRvdykuc2Nyb2xsVG9wKCkgPiBuYXZwb3MudG9wKSB7XG4gICAgICAgICAgICAkKCcudG9wLWhlYWRlcicpLmFkZENsYXNzKCdmaXhlZCcpO1xuICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICAgJCgnLnRvcC1oZWFkZXInKS5yZW1vdmVDbGFzcygnZml4ZWQnKTtcbiAgICAgICAgfVxuICAgICAgICB0cnkge1xuICAgICAgICAgICAgaWYgKCQod2luZG93KS5zY3JvbGxUb3AoKSA+IHNvcnRCdXR0b25Qb3MudG9wIC0gcGFyc2VJbnQoMiAqIHNvcnRCdXR0b24uaGVpZ2h0KCkpKSB7XG4gICAgICAgICAgICAgICAgJCgnLmJ1dHRvbi1jb250YWluZXInKS5hZGRDbGFzcygnZml4ZWQtYnV0dG9ucycpO1xuICAgICAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAgICAgICAkKCcuYnV0dG9uLWNvbnRhaW5lcicpLnJlbW92ZUNsYXNzKCdmaXhlZC1idXR0b25zJyk7XG4gICAgICAgICAgICB9XG4gICAgICAgIH0gY2F0Y2ggKGUpIHt9XG4gICAgfSk7XG5cbiAgICB2YXIgaW1hZ2UgPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgnYXZhdGFyLWNyb3BwZXInKTtcblxuICAgIGZ1bmN0aW9uIHJlYWRVUkwoaW5wdXQpIHtcblxuICAgICAgICBpZiAoaW5wdXQuZmlsZXMgJiYgaW5wdXQuZmlsZXNbMF0pIHtcbiAgICAgICAgICAgIGNvbnNvbGUubG9nKCdSZWFkaW5nIGZpbGUnKTtcbiAgICAgICAgICAgIHZhciByZWFkZXIgPSBuZXcgRmlsZVJlYWRlcigpO1xuXG4gICAgICAgICAgICByZWFkZXIucmVhZEFzRGF0YVVSTChpbnB1dC5maWxlc1swXSk7XG5cbiAgICAgICAgICAgIHJlYWRlci5vbmxvYWQgPSBmdW5jdGlvbihlKSB7XG4gICAgICAgICAgICAgICAgYXZhdGFyQ3JvcHBlci5yZXBsYWNlKGUudGFyZ2V0LnJlc3VsdCk7XG4gICAgICAgICAgICB9O1xuICAgICAgICB9XG4gICAgfVxuXG4gICAgZnVuY3Rpb24gcmVhZEZpbGUoaW5wdXQsIGltZ0VsZW1lbnQpIHtcblxuICAgICAgICBpZiAoaW5wdXQuZmlsZXMgJiYgaW5wdXQuZmlsZXNbMF0pIHtcbiAgICAgICAgICAgIGNvbnNvbGUubG9nKCdSZWFkaW5nIGZpbGUnKTtcbiAgICAgICAgICAgIHZhciByZWFkZXIgPSBuZXcgRmlsZVJlYWRlcigpO1xuXG4gICAgICAgICAgICByZWFkZXIucmVhZEFzRGF0YVVSTChpbnB1dC5maWxlc1swXSk7XG5cbiAgICAgICAgICAgIHJlYWRlci5vbmxvYWQgPSBmdW5jdGlvbihlKSB7XG4gICAgICAgICAgICAgICAgJChpbWdFbGVtZW50KS5hdHRyKCdzcmMnLCBlLnRhcmdldC5yZXN1bHQpO1xuICAgICAgICAgICAgfTtcbiAgICAgICAgfVxuICAgIH1cblxuICAgIHZhciAkcmVwbHlUb2dnbGUgPSAkKCcucmVwbHktdG9nZ2xlJyk7XG5cbiAgICAkcmVwbHlUb2dnbGUuY2xpY2soZnVuY3Rpb24oKSB7XG4gICAgICAgICQodGhpcykuY2hpbGRyZW4oKS5zaG93KCk7XG4gICAgICAgICQodGhpcykuY2hpbGRyZW4oJy5yZXBseS1idG4nKS5oaWRlKCk7XG4gICAgfSk7XG5cblxuICAgIHZhciBhbmNob3IgPSB3aW5kb3cubG9jYXRpb24uaGFzaDtcbiAgICBpZiAoYW5jaG9yID09ICcjcmVwbHlUb3AnKSB7XG4gICAgICAgICQoYW5jaG9yKS5jaGlsZHJlbignLnJlcGx5LWZvcm0nKS5zaG93KCk7XG4gICAgICAgICQoYW5jaG9yKS5jaGlsZHJlbignLnJlcGx5LWJ0bicpLmhpZGUoKTtcbiAgICB9XG5cblxuICAgICQoJyNhdmF0YXItZmlsZScpLmNoYW5nZShmdW5jdGlvbigpIHtcbiAgICAgICAgcmVhZFVSTCh0aGlzKTtcbiAgICB9KTtcblxuICAgIC8vICQoJy5vcHVzLW92ZXJsYXknKS5vbignaG92ZXInLCBmdW5jdGlvbigpIHtcbiAgICAvLyAgICAgY29uc29sZS5sb2coJ292ZXJsYXkgdHJpZ2dlcicpO1xuICAgIC8vICAgICAkKHRoaXMpLmZhZGVJbigzMDApO1xuICAgIC8vIH0sIGZ1bmN0aW9uKCkge1xuICAgIC8vICAgICAkKHRoaXMpLmZhZGVPdXQoMzAwKTtcbiAgICAvLyB9KTtcblxuICAgICQoJyNpbWFnZScpLmNoYW5nZShmdW5jdGlvbigpIHtcbiAgICAgICAgcmVhZEZpbGUodGhpcywgJyNwcmV2aWV3LXVwbG9hZCcpO1xuICAgICAgICByZWFkRmlsZSh0aGlzLCAnI3ByZXZpZXctZWRpdCcpO1xuICAgICAgICAkKCcjcHJldmlldy11cGxvYWQnKS5zaG93KCk7XG4gICAgICAgICQoJ2Rpdi5wcmV2aWV3LWNvbnRhaW5lcicpLnNob3coKTtcbiAgICB9KTtcblxuICAgIHRyeSB7XG4gICAgICAgIHZhciBhdmF0YXJDcm9wcGVyID0gbmV3IENyb3BwZXIoaW1hZ2UsIHtcbiAgICAgICAgICAgIGFzcGVjdFJhdGlvOiAxLFxuICAgICAgICAgICAgY3JvcDogZnVuY3Rpb24oZSkge1xuICAgICAgICAgICAgICAgIC8vIGNvbnNvbGUubG9nKGUuZGV0YWlsLngpO1xuICAgICAgICAgICAgICAgIC8vIGNvbnNvbGUubG9nKGUuZGV0YWlsLnkpO1xuICAgICAgICAgICAgICAgIC8vIGNvbnNvbGUubG9nKGUuZGV0YWlsLndpZHRoKTtcbiAgICAgICAgICAgICAgICAvLyBjb25zb2xlLmxvZyhlLmRldGFpbC5oZWlnaHQpO1xuICAgICAgICAgICAgfVxuICAgICAgICB9KTtcbiAgICB9IGNhdGNoIChlKSB7fVxuXG4gICAgJCgnLmNyb3Atc3VibWl0Jykub24oJ2NsaWNrJywgZnVuY3Rpb24oZSkge1xuICAgICAgICBjb25zb2xlLmxvZygnQ3JvcHBpbmcgYXZhdGFyJyk7XG4gICAgICAgIHZhciBmb3JtT2JqID0gJCgnI2F2YXRhci1mb3JtJyk7XG4gICAgICAgIHZhciBmb3JtVVJMID0gZm9ybU9iai5hdHRyKFwiYWN0aW9uXCIpO1xuICAgICAgICB2YXIgdG9rZW4gPSAkKCdpbnB1dFtuYW1lPV90b2tlbl0nKTtcblxuICAgICAgICBjb25zb2xlLmxvZyhmb3JtVVJMKTtcbiAgICAgICAgYXZhdGFyQ3JvcHBlci5nZXRDcm9wcGVkQ2FudmFzKCkudG9CbG9iKGZ1bmN0aW9uKGJsb2IpIHtcbiAgICAgICAgICAgIHZhciBmb3JtRGF0YSA9IG5ldyBGb3JtRGF0YSgpO1xuXG5cbiAgICAgICAgICAgIGZvcm1EYXRhLmFwcGVuZCgnaW1hZ2UnLCBibG9iKTtcbiAgICAgICAgICAgIGNvbnNvbGUubG9nKGZvcm1EYXRhKTtcblxuICAgICAgICAgICAgLy8gVXNlIGBqUXVlcnkuYWpheGAgbWV0aG9kXG4gICAgICAgICAgICAkLmFqYXgoe1xuICAgICAgICAgICAgICAgIHVybDogZm9ybVVSTCxcbiAgICAgICAgICAgICAgICBtZXRob2Q6IFwiUE9TVFwiLFxuICAgICAgICAgICAgICAgIGRhdGE6IGZvcm1EYXRhLFxuICAgICAgICAgICAgICAgIGhlYWRlcnM6IHtcbiAgICAgICAgICAgICAgICAgICAgJ1gtQ1NSRi1UT0tFTic6IHRva2VuLnZhbCgpXG4gICAgICAgICAgICAgICAgfSxcbiAgICAgICAgICAgICAgICBwcm9jZXNzRGF0YTogZmFsc2UsXG4gICAgICAgICAgICAgICAgY29udGVudFR5cGU6IGZhbHNlLFxuICAgICAgICAgICAgICAgIHN1Y2Nlc3M6IGZ1bmN0aW9uKCkge1xuICAgICAgICAgICAgICAgICAgICBjb25zb2xlLmxvZygnVXBsb2FkIHN1Y2Nlc3MnKTtcbiAgICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgICAgIGVycm9yOiBmdW5jdGlvbigpIHtcbiAgICAgICAgICAgICAgICAgICAgY29uc29sZS5sb2coJ1VwbG9hZCBlcnJvcicpO1xuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgIH0pO1xuXG4gICAgICAgIH0pO1xuICAgICAgICBlLnByZXZlbnREZWZhdWx0KCk7XG4gICAgICAgIHdpbmRvdy5zZXRUaW1lb3V0KGZ1bmN0aW9uKCkge1xuICAgICAgICAgICAgbG9jYXRpb24ucmVsb2FkKCk7XG4gICAgICAgIH0sIDIwMDApXG4gICAgfSk7XG59KTsiXX0=
