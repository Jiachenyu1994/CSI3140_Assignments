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


        reCalculateWaitTime($pdo,$severity,$wait_time);
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



function reCalculateWaitTime($pdo,$severity,$wait_time){
    try{
        // get all patient_id with larger serverity
        $getIdStmt=$pdo->prepare('SELECT patient_id from Patients
                            Where severity> :newSeverity' );
        $getIdStmt->execute(['newSeverity' => $severity]);
        $patientIdArray=$getIdStmt->fetchAll(PDO::FETCH_ASSOC);
        // sql for update wait time by adding new wait_time
        $updateStmt=$pdo->prepare('UPDATE Waittimes SET wait_time = wait_time + :newtime 
                                    where patient_id= :patient_id');

        if(!empty($patientIdArray)){
            foreach($patientIdArray as $id){
                $updateStmt->execute(['newtime' => $wait_time ,'patient_id'=>$id['patient_id']]);
            }
        }

        
    }catch (PDOException $e) {
        $pdo->rollBack();
        
    }catch (Exception $e) {
        $pdo->rollBack();
    }
    
}
?>
