$(document).ready(function() {
    $.ajax({
        type: 'POST',
        url: 'php/get_wait_time.php',
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                $('#wait-time').text(response.wait_time + ' minutes');
            } else {
                $('#wait-time').text('Error: ' + response.message);
            }
        },
        error: function() {
            $('#wait-time').text('There was an error processing your request.');
        }
    });
});
