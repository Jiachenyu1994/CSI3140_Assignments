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