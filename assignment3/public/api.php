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
    // refresh the game
    case "reset":
        session_destroy();
        exit();
    // init game map
    case "makeMap":
        $size=isset($_GET["size"]) ? $_GET["size"] : "";
        if($size<10 || $size==""){
            echo json_encode(["error"=>"Map size need to be a integer larger than 10"]);
        }else{
            $reponse=["map" => $game->makeMap($size)];
            $_SESSION["game"]=serialize($game);
            echo json_encode($reponse);
        }
        break;
    // run the game
    case "runGame":
        $status=$game->run();
        $map=$game->getMap();
        $dir=$game->pDir();
        if($map==[]){
            $reponse=["error"=> "Please make map first"];
        }else{
            
            $score=$game->getScore();
            $reponse = [
                "status" => $status,
                "score" => $score,
                "map" => $map,
                "dir"=> $dir
            ];
            
        }
        echo json_encode($reponse);
        $_SESSION["game"]=serialize($game);
        
        break;
    case "nextLevel":
        $size=isset($_GET["size"]) ? $_GET["size"] : "";
        $game->nextLevel($size);
        $_SESSION["game"]=serialize($game);
        $reponse=["map"=> $game->getMap()];
        echo json_encode($reponse);
        break;
    case "goRight":
        $game->pGoRight();
        $_SESSION["game"]=serialize($game);
        break;
    case "goLeft":
        $game->pGoLeft();
        $_SESSION["game"]=serialize($game);
        break;
    case "record":
        $score=$game->getScore();
        $id=isset($_GET["id"]) ? $_GET["id"] :"";
        $filePath="data.json";
        if (file_exists($filePath)) {
            $jsonData = file_get_contents($filePath);
            $data = json_decode($jsonData, true);
            $found=false;
            foreach ($data as $key => $value) {
                if ($key == $id) {
                    $found=true;
                    if($value<$score){
                        $data[$key] = $score;
                    }
                    break;
                }
            }
            if(!$found){
                $newData=[$id=>$score];
                $data = array_merge($data, $newData); 
            }
            print_r($data);
        } else {
            $data = [];
            $newData=[$id=>$score];
            $data = array_merge($data, $newData);   
        }

        
    
        $jsonData = json_encode($data, JSON_PRETTY_PRINT);
        file_put_contents('data.json', $jsonData);
        // $_SESSION["game"]=serialize($game);
        break;
    case "read":
        $jsonData = file_get_contents('data.json');
        echo ($jsonData);
        
        break;
    default:
        echo json_encode(["error"=>"invalid action"]);
        break;
    }