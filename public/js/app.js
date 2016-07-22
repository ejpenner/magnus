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
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIi4uLy4uLy5ucG0tbG9jYWwvZ2FsbGVyeS1hcHAvbm9kZV9tb2R1bGVzL2Jyb3dzZXJpZnkvbm9kZV9tb2R1bGVzL2Jyb3dzZXItcGFjay9fcHJlbHVkZS5qcyIsInJlc291cmNlcy9hc3NldHMvanMvYXBwLmpzIl0sIm5hbWVzIjpbXSwibWFwcGluZ3MiOiJBQUFBO0FDQUE7O0FBQ0EsRUFBRSxRQUFGLEVBQVksS0FBWixDQUFrQixZQUFXOztBQUV6QixRQUFJLFdBQVcsRUFBRSxXQUFGLENBQWY7QUFDQSxRQUFJLFVBQVUsRUFBRSxVQUFGLENBQWQ7QUFDQSxRQUFJLFVBQVUsT0FBTyxRQUFQLENBQWdCLElBQTlCO0FBQ0EsUUFBSSxZQUFZLEVBQUUsYUFBRixDQUFoQjtBQUNBLFFBQUksU0FBUyxVQUFVLE1BQVYsRUFBYjtBQUNBLFFBQUksYUFBYSxFQUFFLG1CQUFGLENBQWpCO0FBQ0EsUUFBSSxnQkFBZ0IsV0FBVyxNQUFYLEVBQXBCO0FBQ0EsUUFBSSxRQUFRLFNBQVMsY0FBVCxDQUF3QixnQkFBeEIsQ0FBWjs7QUFFQSxXQUFPLFVBQVAsQ0FBa0IsWUFBVztBQUN6QixVQUFFLGdCQUFGLEVBQW9CLE1BQXBCLENBQTJCLEdBQTNCLEVBQWdDLENBQWhDLEVBQW1DLE9BQW5DLENBQTJDLEdBQTNDLEVBQWdELFlBQVc7QUFDdkQsY0FBRSxJQUFGLEVBQVEsTUFBUjtBQUNILFNBRkQ7QUFHSCxLQUpELEVBSUcsSUFKSDs7QUFNQSxNQUFFLGlCQUFGLEVBQXFCLEVBQXJCLENBQXdCLFFBQXhCLEVBQWtDLFlBQVc7QUFDekMsZUFBTyxRQUFRLHVDQUFSLENBQVA7QUFDSCxLQUZEOztBQUlBLFlBQVEsS0FBUixDQUFjLFlBQVc7QUFDckIsVUFBRSxlQUFGLEVBQW1CLElBQW5COztBQUVBLFVBQUUsSUFBRixFQUFRLE1BQVI7QUFDQSxpQkFBUyxJQUFULEdBQWdCLE1BQWhCO0FBQ0gsS0FMRDs7QUFPQSxhQUFTLEtBQVQsQ0FBZSxZQUFXO0FBQ3RCLFVBQUUs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QUNILHFCQUFLLE9BREY7QUFFSCx3QkFBUSxNQUZMO0FBR0gsc0JBQU0sUUFISDtBQUlILHlCQUFTO0FBQ0wsb0NBQWdCLE1BQU0sR0FBTjtBQURYLGlCQUpOO0FBT0gsNkJBQWEsS0FQVjtBQVFILDZCQUFhLEtBUlY7QUFTSCx5QkFBUyxZQUFXO0FBQ2hCLDRCQUFRLEdBQVIsQ0FBWSxnQkFBWjtBQUNILGlCQVhFO0FBWUgsdUJBQU8sWUFBVztBQUNkLDRCQUFRLEdBQVIsQ0FBWSxjQUFaO0FBQ0g7QUFkRSxhQUFQO0FBaUJILFNBekJEO0FBMEJBLFVBQUUsY0FBRjtBQUNBLGVBQU8sVUFBUCxDQUFrQixZQUFXO0FBQ3pCLHFCQUFTLE1BQVQ7QUFDSCxTQUZELEVBRUcsSUFGSDtBQUdILEtBckNEO0FBc0NILENBbkxEIiwiZmlsZSI6ImdlbmVyYXRlZC5qcyIsInNvdXJjZVJvb3QiOiIiLCJzb3VyY2VzQ29udGVudCI6WyIoZnVuY3Rpb24gZSh0LG4scil7ZnVuY3Rpb24gcyhvLHUpe2lmKCFuW29dKXtpZighdFtvXSl7dmFyIGE9dHlwZW9mIHJlcXVpcmU9PVwiZnVuY3Rpb25cIiYmcmVxdWlyZTtpZighdSYmYSlyZXR1cm4gYShvLCEwKTtpZihpKXJldHVybiBpKG8sITApO3ZhciBmPW5ldyBFcnJvcihcIkNhbm5vdCBmaW5kIG1vZHVsZSAnXCIrbytcIidcIik7dGhyb3cgZi5jb2RlPVwiTU9EVUxFX05PVF9GT1VORFwiLGZ9dmFyIGw9bltvXT17ZXhwb3J0czp7fX07dFtvXVswXS5jYWxsKGwuZXhwb3J0cyxmdW5jdGlvbihlKXt2YXIgbj10W29dWzFdW2VdO3JldHVybiBzKG4/bjplKX0sbCxsLmV4cG9ydHMsZSx0LG4scil9cmV0dXJuIG5bb10uZXhwb3J0c312YXIgaT10eXBlb2YgcmVxdWlyZT09XCJmdW5jdGlvblwiJiZyZXF1aXJlO2Zvcih2YXIgbz0wO288ci5sZW5ndGg7bysrKXMocltvXSk7cmV0dXJuIHN9KSIsIlwidXNlIHN0cmljdFwiO1xuJChkb2N1bWVudCkucmVhZHkoZnVuY3Rpb24oKSB7XG5cbiAgICB2YXIgZnVsbHZpZXcgPSAkKCcjZnVsbHZpZXcnKTtcbiAgICB2YXIgcHJldmlldyA9ICQoJyNwcmV2aWV3Jyk7XG4gICAgdmFyIGhhc2hWYWwgPSB3aW5kb3cubG9jYXRpb24uaGFzaDtcbiAgICB2YXIgdG9wSGVhZGVyID0gJCgnLnRvcC1oZWFkZXInKTtcbiAgICB2YXIgbmF2cG9zID0gdG9wSGVhZGVyLm9mZnNldCgpO1xuICAgIHZhciBzb3J0QnV0dG9uID0gJCgnLmJ1dHRvbi1jb250YWluZXInKTtcbiAgICB2YXIgc29ydEJ1dHRvblBvcyA9IHNvcnRCdXR0b24ub2Zmc2V0KCk7XG4gICAgdmFyIGltYWdlID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ2F2YXRhci1jcm9wcGVyJyk7XG5cbiAgICB3aW5kb3cuc2V0VGltZW91dChmdW5jdGlvbigpIHtcbiAgICAgICAgJCgnLmFsZXJ0LXN1Y2Nlc3MnKS5mYWRlVG8oNTAwLCAwKS5zbGlkZVVwKDUwMCwgZnVuY3Rpb24oKSB7XG4gICAgICAgICAgICAkKHRoaXMpLnJlbW92ZSgpO1xuICAgICAgICB9KTtcbiAgICB9LCAzMDAwKTtcblxuICAgICQoJy5kZWxldGUtY29uZmlybScpLm9uKCdzdWJtaXQnLCBmdW5jdGlvbigpIHtcbiAgICAgICAgcmV0dXJuIGNvbmZpcm0oJ0FyZSB5b3Ugc3VyZSB5b3Ugd2FudCB0byBkZWxldGUgdGhpcz8nKTtcbiAgICB9KTtcblxuICAgIHByZXZpZXcuY2xpY2soZnVuY3Rpb24oKSB7XG4gICAgICAgICQoJy5mdWxsdmlldy1ib3gnKS5zaG93KCk7XG4gICAgICAgIC8vJCgnI29wdXMtaW1hZ2UnKS5jc3MoJ3dpZHRoJywgJzEwMCUnKTtcbiAgICAgICAgJCh0aGlzKS50b2dnbGUoKTtcbiAgICAgICAgZnVsbHZpZXcuc2hvdygpLnVudmVpbCgpO1xuICAgIH0pO1xuXG4gICAgZnVsbHZpZXcuY2xpY2soZnVuY3Rpb24oKSB7XG4gICAgICAgICQodGhpcykudG9nZ2xlKCk7XG4gICAgICAgIC8vJCgnI29wdXMtaW1hZ2UnKS5jc3MoJ3dpZHRoJywgJzgwJScpO1xuICAgICAgICAkKCcuZnVsbHZpZXctYm94JykudG9nZ2xlKCk7XG4gICAgICAgIHByZXZpZXcudG9nZ2xlKCk7XG4gICAgfSk7XG5cbiAgICBpZiAoaGFzaFZhbC5pbmRleE9mKCdmdWxsJykgIT0gLTEpIHtcbiAgICAgICAgcHJldmlldy50b2dnbGUoKTtcbiAgICAgICAgJCgnLmZ1bGx2aWV3LWJveCcpLnNob3coKTtcbiAgICAgICAgZnVsbHZpZXcuc2hvdygpLnVudmVpbCgpO1xuICAgIH1cblxuICAgICQoJyNzZWxlY3RBbGxPcHVzJykuY2xpY2soZnVuY3Rpb24oKSB7XG4gICAgICAgIHZhciBjaGVja2JveCA9ICQoJy5vcHVzLW1lc3NhZ2Utc2VsZWN0Jyk7XG4gICAgICAgIGNoZWNrYm94LnByb3AoJ2NoZWNrZWQnLCAhY2hlY2tib3guaXMoXCI6Y2hlY2tlZFwiKSk7XG4gICAgfSk7XG5cblxuICAgIC8vdmFyIG51bSA9IDE1MDsgLy9udW1iZXIgb2YgcGl4ZWxzIGJlZm9yZSBtb2RpZnlpbmcgc3R5bGVzXG5cbiAgICAkKHdpbmRvdykuYmluZCgnc2Nyb2xsJywgZnVuY3Rpb24oKSB7XG5cbiAgICAgICAgdmFyIHggPSAkKHRoaXMpLnNjcm9sbFRvcCgpO1xuICAgICAgICAkKCcjaGVhZGVyLWJhY2tncm91bmQnKS5jc3MoJ2JhY2tncm91bmQtcG9zaXRpb24nLCAnMTAwJSAnICsgcGFyc2VJbnQoLXgpICsgJ3B4JyArICcsIDAlICcgKyBwYXJzZUludCgteCkgKyAncHgsIGNlbnRlciB0b3AnKTtcblxuICAgICAgICBpZiAoJCh3aW5kb3cpLnNjcm9sbFRvcCgpID4gbmF2cG9zLnRvcCkge1xuICAgICAgICAgICAgdG9wSGVhZGVyLmFkZENsYXNzKCdmaXhlZCcpO1xuICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICAgdG9wSGVhZGVyLnJlbW92ZUNsYXNzKCdmaXhlZCcpO1xuICAgICAgICB9XG4gICAgICAgIHRyeSB7XG4gICAgICAgICAgICBpZiAoJCh3aW5kb3cpLnNjcm9sbFRvcCgpID4gc29ydEJ1dHRvblBvcy50b3AgLSBwYXJzZUludCgyICogc29ydEJ1dHRvbi5oZWlnaHQoKSkpIHtcbiAgICAgICAgICAgICAgICAkKCcuYnV0dG9uLWNvbnRhaW5lcicpLmFkZENsYXNzKCdmaXhlZC1idXR0b25zJyk7XG4gICAgICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICAgICAgICQoJy5idXR0b24tY29udGFpbmVyJykucmVtb3ZlQ2xhc3MoJ2ZpeGVkLWJ1dHRvbnMnKTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgfSBjYXRjaCAoZSkge31cbiAgICB9KTtcblxuICAgIGZ1bmN0aW9uIHJlYWRVUkwoaW5wdXQpIHtcblxuICAgICAgICBpZiAoaW5wdXQuZmlsZXMgJiYgaW5wdXQuZmlsZXNbMF0pIHtcbiAgICAgICAgICAgIGNvbnNvbGUubG9nKCdSZWFkaW5nIGZpbGUnKTtcbiAgICAgICAgICAgIHZhciByZWFkZXIgPSBuZXcgRmlsZVJlYWRlcigpO1xuXG4gICAgICAgICAgICByZWFkZXIucmVhZEFzRGF0YVVSTChpbnB1dC5maWxlc1swXSk7XG5cbiAgICAgICAgICAgIHJlYWRlci5vbmxvYWQgPSBmdW5jdGlvbihlKSB7XG4gICAgICAgICAgICAgICAgYXZhdGFyQ3JvcHBlci5yZXBsYWNlKGUudGFyZ2V0LnJlc3VsdCk7XG4gICAgICAgICAgICB9O1xuICAgICAgICB9XG4gICAgfVxuXG4gICAgZnVuY3Rpb24gcmVhZEZpbGUoaW5wdXQsIGltZ0VsZW1lbnQpIHtcblxuICAgICAgICBpZiAoaW5wdXQuZmlsZXMgJiYgaW5wdXQuZmlsZXNbMF0pIHtcbiAgICAgICAgICAgIGNvbnNvbGUubG9nKCdSZWFkaW5nIGZpbGUnKTtcbiAgICAgICAgICAgIHZhciByZWFkZXIgPSBuZXcgRmlsZVJlYWRlcigpO1xuXG4gICAgICAgICAgICByZWFkZXIucmVhZEFzRGF0YVVSTChpbnB1dC5maWxlc1swXSk7XG5cbiAgICAgICAgICAgIHJlYWRlci5vbmxvYWQgPSBmdW5jdGlvbihlKSB7XG4gICAgICAgICAgICAgICAgJChpbWdFbGVtZW50KS5hdHRyKCdzcmMnLCBlLnRhcmdldC5yZXN1bHQpO1xuICAgICAgICAgICAgfTtcbiAgICAgICAgfVxuICAgIH1cblxuICAgIHZhciAkcmVwbHlUb2dnbGUgPSAkKCcucmVwbHktdG9nZ2xlJyk7XG5cbiAgICAkcmVwbHlUb2dnbGUuY2xpY2soZnVuY3Rpb24oKSB7XG4gICAgICAgICQodGhpcykuY2hpbGRyZW4oKS5zaG93KCk7XG4gICAgICAgICQodGhpcykuY2hpbGRyZW4oJy5yZXBseS1idG4nKS5oaWRlKCk7XG4gICAgfSk7XG5cblxuICAgIHZhciBhbmNob3IgPSB3aW5kb3cubG9jYXRpb24uaGFzaDtcbiAgICBpZiAoYW5jaG9yID09ICcjcmVwbHlUb3AnKSB7XG4gICAgICAgICQoYW5jaG9yKS5jaGlsZHJlbignLnJlcGx5LWZvcm0nKS5zaG93KCk7XG4gICAgICAgICQoYW5jaG9yKS5jaGlsZHJlbignLnJlcGx5LWJ0bicpLmhpZGUoKTtcbiAgICB9XG5cblxuICAgICQoJyNhdmF0YXItZmlsZScpLmNoYW5nZShmdW5jdGlvbigpIHtcbiAgICAgICAgcmVhZFVSTCh0aGlzKTtcbiAgICB9KTtcblxuICAgIC8vICQoJy5vcHVzLW92ZXJsYXknKS5vbignaG92ZXInLCBmdW5jdGlvbigpIHtcbiAgICAvLyAgICAgY29uc29sZS5sb2coJ292ZXJsYXkgdHJpZ2dlcicpO1xuICAgIC8vICAgICAkKHRoaXMpLmZhZGVJbigzMDApO1xuICAgIC8vIH0sIGZ1bmN0aW9uKCkge1xuICAgIC8vICAgICAkKHRoaXMpLmZhZGVPdXQoMzAwKTtcbiAgICAvLyB9KTtcblxuICAgICQoJyNpbWFnZScpLmNoYW5nZShmdW5jdGlvbigpIHtcbiAgICAgICAgcmVhZEZpbGUodGhpcywgJyNwcmV2aWV3LXVwbG9hZCcpO1xuICAgICAgICByZWFkRmlsZSh0aGlzLCAnI3ByZXZpZXctZWRpdCcpO1xuICAgICAgICAkKCcjcHJldmlldy11cGxvYWQnKS5zaG93KCk7XG4gICAgICAgICQoJ2Rpdi5wcmV2aWV3LWNvbnRhaW5lcicpLnNob3coKTtcbiAgICB9KTtcblxuICAgIHRyeSB7XG4gICAgICAgIHZhciBhdmF0YXJDcm9wcGVyID0gbmV3IENyb3BwZXIoaW1hZ2UsIHtcbiAgICAgICAgICAgIGFzcGVjdFJhdGlvOiAxLFxuICAgICAgICAgICAgY3JvcDogZnVuY3Rpb24oZSkge1xuICAgICAgICAgICAgICAgIC8vIGNvbnNvbGUubG9nKGUuZGV0YWlsLngpO1xuICAgICAgICAgICAgICAgIC8vIGNvbnNvbGUubG9nKGUuZGV0YWlsLnkpO1xuICAgICAgICAgICAgICAgIC8vIGNvbnNvbGUubG9nKGUuZGV0YWlsLndpZHRoKTtcbiAgICAgICAgICAgICAgICAvLyBjb25zb2xlLmxvZyhlLmRldGFpbC5oZWlnaHQpO1xuICAgICAgICAgICAgfVxuICAgICAgICB9KTtcbiAgICB9IGNhdGNoIChlKSB7fVxuXG4gICAgJCgnLmNyb3Atc3VibWl0Jykub24oJ2NsaWNrJywgZnVuY3Rpb24oZSkge1xuICAgICAgICBjb25zb2xlLmxvZygnQ3JvcHBpbmcgYXZhdGFyJyk7XG4gICAgICAgIHZhciBmb3JtT2JqID0gJCgnI2F2YXRhci1mb3JtJyk7XG4gICAgICAgIHZhciBmb3JtVVJMID0gZm9ybU9iai5hdHRyKFwiYWN0aW9uXCIpO1xuICAgICAgICB2YXIgdG9rZW4gPSAkKCdpbnB1dFtuYW1lPV90b2tlbl0nKTtcblxuICAgICAgICBjb25zb2xlLmxvZyhmb3JtVVJMKTtcbiAgICAgICAgYXZhdGFyQ3JvcHBlci5nZXRDcm9wcGVkQ2FudmFzKCkudG9CbG9iKGZ1bmN0aW9uKGJsb2IpIHtcbiAgICAgICAgICAgIHZhciBmb3JtRGF0YSA9IG5ldyBGb3JtRGF0YSgpO1xuXG5cbiAgICAgICAgICAgIGZvcm1EYXRhLmFwcGVuZCgnaW1hZ2UnLCBibG9iKTtcbiAgICAgICAgICAgIGNvbnNvbGUubG9nKGZvcm1EYXRhKTtcblxuICAgICAgICAgICAgLy8gVXNlIGBqUXVlcnkuYWpheGAgbWV0aG9kXG4gICAgICAgICAgICAkLmFqYXgoe1xuICAgICAgICAgICAgICAgIHVybDogZm9ybVVSTCxcbiAgICAgICAgICAgICAgICBtZXRob2Q6IFwiUE9TVFwiLFxuICAgICAgICAgICAgICAgIGRhdGE6IGZvcm1EYXRhLFxuICAgICAgICAgICAgICAgIGhlYWRlcnM6IHtcbiAgICAgICAgICAgICAgICAgICAgJ1gtQ1NSRi1UT0tFTic6IHRva2VuLnZhbCgpXG4gICAgICAgICAgICAgICAgfSxcbiAgICAgICAgICAgICAgICBwcm9jZXNzRGF0YTogZmFsc2UsXG4gICAgICAgICAgICAgICAgY29udGVudFR5cGU6IGZhbHNlLFxuICAgICAgICAgICAgICAgIHN1Y2Nlc3M6IGZ1bmN0aW9uKCkge1xuICAgICAgICAgICAgICAgICAgICBjb25zb2xlLmxvZygnVXBsb2FkIHN1Y2Nlc3MnKTtcbiAgICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgICAgIGVycm9yOiBmdW5jdGlvbigpIHtcbiAgICAgICAgICAgICAgICAgICAgY29uc29sZS5sb2coJ1VwbG9hZCBlcnJvcicpO1xuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgIH0pO1xuXG4gICAgICAgIH0pO1xuICAgICAgICBlLnByZXZlbnREZWZhdWx0KCk7XG4gICAgICAgIHdpbmRvdy5zZXRUaW1lb3V0KGZ1bmN0aW9uKCkge1xuICAgICAgICAgICAgbG9jYXRpb24ucmVsb2FkKCk7XG4gICAgICAgIH0sIDIwMDApXG4gICAgfSk7XG59KTsiXX0=
