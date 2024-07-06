<?php
require_once('../config/_config.php');

use app\models\Game;
use app\models\Ghost;
use app\models\Pacman;


header("Content-Type: application/json");

$action = isset($_GET["action"]) ? $_GET["action"] : "";

if(!isset($_SESSION["game"])){
    $pacman=new Pacman();
    $ghost=new Ghost();
    $game = new Game($pacman, $ghost);
    $_SESSION["game"]=serialize($game);
}else{
    $game= unserialize($_SESSION["game"]);
}



switch ($action) {
    case "makeMap":
        $size=isset($_GET["size"]) ? $_GET["size"] : "";
        if($size<3 || $size==""){
            echo json_encode(["error"=>"Map size need to be a integer larger than 3"]);
        }else{
            $reponse=["map" => $game->makeMap($size)];
            echo json_encode($reponse);
        }
        
        break;
    default:
        echo json_encode(["error"=>"invalid action"]);
        break;
    }