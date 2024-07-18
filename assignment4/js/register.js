$(document).ready(function() {
    $('#registerForm').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            type: 'POST',
            url: 'php/register_patient.php',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert(response.message);
                    // Optionally, clear the form
                    $('#registerForm')[0].reset();
                } else {
                    alert(response.message);
                }
                location.reload();
            },
            error: function() {
                alert('There was an error processing your request.');
            }
        });
    });
});
