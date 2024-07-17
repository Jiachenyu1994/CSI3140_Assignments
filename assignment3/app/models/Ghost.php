<?php
namespace app\models;

class Ghost{
    private $location;

    private $dir;

    public function __construct(){
        $this->location = 0;
    }

    public function get_Location(){
        return $this->location;
    }
    public function setLocation($location){
        $this->location = $location;
    }


    public function move($map,$power){

        for ($i = 0; $i < count($map); $i++) {
            $elem = $map[$i];
            if ($elem == "^." || $elem == "^"||$elem == "^@") {
                $this->dir = 1;
                break;
            } else if ($elem == "." || $elem == "@" || $elem == " ") {
                // Do nothing
            } else {
                $this->dir = 0;
                break;
            }
        }
        if($power==false){
            if ($this->dir == 1) {
                $this->gohostRight($map);
            } else {
                $this->gohostleft($map);
            }
        }else{
            if ($this->dir == 0) {
                $this->gohostRight($map);
            } else {
                $this->gohostleft($map);
            }
        }

    }


    public function gohostRight($map){
        $mapSize=count($map);
        $this->location++;
        if ($this->location >=  $mapSize) {
            $this->location = 0;
        }
            
        

    }
    public function gohostleft($map){
        $mapSize=count($map);
        $this->location--;
        if ($this->location <=  0) {
            $this->location = $mapSize-1;
        }
        
    }
    

}