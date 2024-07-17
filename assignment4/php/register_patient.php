<?php
session_start();
include 'db_connect.php';

header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $unique_code = $_POST['unique_code'];
    $severity = $_POST['severity'];
    $wait_time = $_POST['wait_time'];

    try {
        if (!$pdo) {
            throw new Exception('Database connection failed.');
        }

        // Begin a transaction
        $pdo->beginTransaction();

        // Insert into Patients table
        $stmt = $pdo->prepare('INSERT INTO Patients (name, unique_code, severity) VALUES (:name, :unique_code, :severity)');
        $stmt->execute(['name' => $name, 'unique_code' => $unique_code, 'severity' => $severity]);
        
        // Get the patient_id of the newly inserted patient
        $patient_id = $pdo->lastInsertId();

        // Insert into WaitTimes table
        $stmt = $pdo->prepare('INSERT INTO WaitTimes (patient_id, wait_time) VALUES (:patient_id, :wait_time)');
        $stmt->execute(['patient_id' => $patient_id, 'wait_time' => $wait_time]);

        // Commit the transaction
        $pdo->commit();

        $response['success'] = true;
        $response['message'] = 'Patient registered successfully';
    } catch (PDOException $e) {
        // Rollback the transaction in case of error
        $pdo->rollBack();
        $response['message'] = 'Database error: ' . $e->getMessage();
    } catch (Exception $e) {
        $pdo->rollBack();
        $response['message'] = 'Error: ' . $e->getMessage();
    }
} else {
    $response['message'] = 'Invalid request method';
}

echo json_encode($response);
?>
