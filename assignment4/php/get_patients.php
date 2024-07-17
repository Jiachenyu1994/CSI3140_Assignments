<?php
session_start();
include 'db_connect.php';

header('Content-Type: application/json');

$response = ['success' => false, 'message' => '', 'patients' => []];

if (!isset($_SESSION['admin'])) {
    $response['message'] = 'Not logged in as admin';
    echo json_encode($response);
    exit;
}

try {
    $stmt = $pdo->query('SELECT Patients.name, Patients.severity, WaitTimes.wait_time
                         FROM Patients
                         JOIN WaitTimes ON Patients.patient_id = WaitTimes.patient_id');
    $patients = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($patients) {
        $response['success'] = true;
        $response['patients'] = $patients;
    } else {
        $response['message'] = 'No patients found';
    }
} catch (PDOException $e) {
    $response['message'] = 'Database error: ' . $e->getMessage();
}

echo json_encode($response);
?>
