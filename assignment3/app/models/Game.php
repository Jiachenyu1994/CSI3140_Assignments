<?php
namespace app\models;

class Game{
    private $pacman;
    private $ghost;
    private $map;
    private $score;
    private $size;

    //0:not finish 
    //1:pacman win,next level
    //2:ghost win. you lose 
    private $status; 
                         

    public function __construct(Pacman $pacman,Ghost $ghost){
            $this->pacman = $pacman;
            $this->ghost=$ghost;
            $this->size=0;
            $this->score= 0;
            $this->map = $this->makeMap($this->size);
            $this->status= 0;
    }
    // init map
    public function makeMap($size){
        $this->size=$size;
        $this->map = [];
        if ($size == '') {
            return $this->map;
        }
        if ($size < 3) {
            return $this->map;
        }

        for ($i = 0; $i < $size; $i++) {
            if ($i == floor($size / 3)) {
                array_push($this->map,"C");
                // Clocation = i;
                $this->pacman->set_location($i);
            } else if ($i == floor($size / 2)) {
                array_push($this->map,"@");
            } else if ($i == $size - 3) {
                array_push($this->map,"^.");
                $this->ghost->setLocation($i);
            } else {
                array_push($this->map,".");
            }
        }
        return $this->map;
    }

    function run(){
        $this->updateMap();
        if(!$this->remainPellets()){
            $this->status= 1;
        }
        return $this->status; 
    }

    function getScore(): int{
        return $this->score;
    }

    function updateMap(){
        
        $pLocation=$this->pacman->get_location();
        $gLocation=$this->ghost->get_location();

        $this->pacman->move($this->map);
        $pNext=$this->pacman->get_Location();

        $this->ghost->move($this->map,$this->pacman->get_power());
        $gNext=$this->ghost->get_Location();
 
        
        $this->updatePacmanLocation($pLocation,$pNext);  
        $this->updateGhostLocation($gLocation,$gNext);
    }

    function updateGhostLocation($gLocation,$gNext):void{
        // update map for ghost last location
        switch($this->map[$gLocation]){
            case "^.":
                $this->map[$gLocation] = ".";
                break;
            case "^":
                $this->map[$gLocation] = " ";
                break;
            default:
                $this->map[$gLocation] = "@";
                break;
        }
        // update the map for ghost current location
        switch($this->map[$gNext]){
            case ".":
                $this->map[$gNext] = "^.";
                break;
            case " ":
                $this->map[$gNext]= "^";
                break;
            case "@":
                $this->map[$gNext]= "^@";
                break;
            default:
                $this->map[$gNext] = "^";
                break;
        }
    }

    function updatePacmanLocation($pLocation,$pNext):void{
        // update pacman last location
        $this->map[$pLocation] = " ";
        // update pacman current location
        switch($this->map[$pNext]){
            case ".":
                $this->score++;
                $this->map[$pNext] = "C.";
                break;
            case " ":
                $this->map[$pNext] = "C";
                break;
            case "@":
                $this->score += 10;
                $this->map[$pNext] = "C";
                $this->pacman->set_power(true);
                break;
            default:
                $power=$this->pacman->get_power();
                if ($power == false) {
                    $this->map[$pNext] = "^";
                    $this->status=2;
                }
                if ($power == true) {
                    $this->score += 20;
                    $this->map[$pNext] = "C";
                    $this->status=1;
                }
        }

    }
    function nextLevel($size){
        $this->size=$size;
        $this->status = 0;
        $this->pacman->set_power(false);
        $this->makeMap($size);
    }
    function getMap(){
        return $this->map;
    }

    function remainPellets() {
        $result = false;
        for ($i = 0; $i < count($this->map); $i++) {
            if ($this->map[$i] == "."||$this->map[$i] == "^.") {
                $result = true;
                break;
            }
        }
        return $result;
    }
    function pGoRight(){
        $this->pacman->set_dir(1);
    }

    function pGoLeft(){
        $this->pacman->set_dir(0);
    }


}