<?php

include 'db_connect.php';
header('Content-Type: application/json');


$patient_id=isset($_POST["patient_id"])? $_POST["patient_id"] :"";


$reponse=["message"=> "Error in treat patient"];
if($patient_id== ""){
   
}else{
    try{
        if(!$pdo){
            throw new Exception('Database connection failed.');
        }
        $pdo->beginTransaction();
        updateTimeAfterTreate($patient_id,$pdo);

        $stmt1= $pdo->prepare('DELETE from waittimes where patient_id=:patient_id');
        $stmt1->execute(array('patient_id'=> $patient_id));

        $stmt2= $pdo->prepare('DELETE from Patients where patient_id=:patient_id');
        $stmt2->execute(array('patient_id'=> $patient_id));
        $reponse=["message"=> "Patient treated sucessfully"];

        $pdo->commit();
        
    }catch(Exception $e){
        $reponse=["message"=> $e->getMessage()];
    }

}

echo json_encode($reponse);

function updateTimeAfterTreate($patient_id,$pdo){
    try{
        // get patient severity
        $stmt1= $pdo->prepare("SELECT WaitTimes.wait_time, Patients.severity FROM WaitTimes 
                           JOIN Patients ON WaitTimes.patient_id = Patients.patient_id 
                           where Patients.patient_id=:patient_id");
        $stmt1->execute(array("patient_id"=> $patient_id));
        $result = $stmt1->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $wait_time = $result['wait_time'];
            $severity = $result['severity'];
        } else {
            throw new RuntimeException("the patient is not found");
        }

        // find all patient need minus wait time
        $stmt2= $pdo->prepare("SELECT patient_id from Patients where  severity<:severity or (patient_id>:patient_id and severity=:severity)");
        $stmt2->execute(array("patient_id"=> $patient_id,"severity"=> $severity));
        $patient_idArray=$stmt2->fetchAll(PDO::FETCH_ASSOC);
        
        
        // update patient's wait time (smaller severity and larger patient_id)
        $stmt3= $pdo->prepare("UPDATE Waittimes set wait_time=wait_time-:wait_time where patient_id=:patient_id");
        if(!empty($patient_idArray)){
           
            foreach ($patient_idArray as $patient) {
                $stmt3->execute(["patient_id"=> $patient['patient_id'],"wait_time"=>$wait_time]);
            }
        }
        
        }catch(Exception $e){
            
            throw new RuntimeException($e->getMessage());
        }
        

}