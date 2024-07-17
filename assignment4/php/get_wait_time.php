<?php
session_start();
include 'db_connect.php';

header('Content-Type: application/json');

$response = ['success' => false, 'message' => '', 'wait_time' => ''];

if (!isset($_SESSION['patient'])) {
    $response['message'] = 'Not logged in';
    echo json_encode($response);
    exit;
}

$patient_name = $_SESSION['patient'];

try {
    $stmt = $pdo->prepare('SELECT WaitTimes.wait_time FROM WaitTimes 
                           JOIN Patients ON WaitTimes.patient_id = Patients.patient_id 
                           WHERE Patients.name = :name');
    $stmt->execute(['name' => $patient_name]);
    $wait_time = $stmt->fetchColumn();

    if ($wait_time !== false) {
        $response['success'] = true;
        $response['wait_time'] = $wait_time;
    } else {
        $response['message'] = 'Wait time not found for ' . $patient_name;
    }
} catch (PDOException $e) {
    $response['message'] = 'Database error: ' . $e->getMessage();
}

echo json_encode($response);
?>
