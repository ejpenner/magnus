/**
 * Created by epenner on 5/17/2016.
 */
$(document).ready(function() {

    window.setTimeout(function() {
        $(".alert-success").fadeTo(500, 0).slideUp(500, function() {
            $(this).remove();
        });
    }, 3000);

    $('.delete-confirm').on('submit', function() {
        return confirm('Are you sure you want to delete this?');
    });

});