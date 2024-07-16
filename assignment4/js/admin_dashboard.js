$(document).ready(function() {
    // Fetch patient data and populate the table
    $.ajax({
        type: 'POST',
        url: 'php/get_patients.php',
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                var tbody = $('#patientTable tbody');
                tbody.empty();
                response.patients.forEach(function(patient) {
                    var row = '<tr>' +
                        '<td>' + patient.name + '</td>' +
                        '<td>' + patient.severity + '</td>' +
                        '<td>' + patient.wait_time + '</td>' +
                        '</tr>';
                    tbody.append(row);
                });
            } else {
                alert('Error: ' + response.message);
            }
        },
        error: function() {
            alert('There was an error processing your request.');
        }
    });
});
