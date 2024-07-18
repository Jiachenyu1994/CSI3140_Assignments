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
                        '<td>' + patient.patient_id + '</td>' +
                        '<td>' + patient.name + '</td>' +
                        '<td>' + patient.severity + '</td>' +
                        '<td>' + patient.wait_time + '</td>' +
                        '<td>  <button id=patient-' + patient.patient_id + '>Treated</button> </td>' +
                        '</tr>';
                    tbody.append(row);

                    // add a event listener for treate button
                    $('#patient-'+patient.patient_id).click(function (e) { 
                        e.preventDefault();
                        treatPatient(patient.patient_id);
                    });

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

function treatPatient(patient_id){
    $.ajax({
        type: "Post",
        url: "../php/treate_patients.php",
        data: { patient_id: patient_id},
        dataType: "json",
        success: function (response) {
            alert(response.message);
            location.reload();
        }
    });
}