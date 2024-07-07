<?php
namespace app\models;

class Pacman{
    private $location;
    private $power=false;

    // 1: right , 0:left
    private $dir=1;  
    public function __construct(){
        $this->location = 0;
        $this->power = 0;
    }

    public function get_location(){
        return $this->location;
    }
   
    public function move($map){
        $mapSize=count($map);
        if($this->dir== 1){
            $this->location++;
            if ($this->location >=  $mapSize) {
                $this->location = 0;
            }
        }else{
            $this->location--;
            if ($this->location <=  0) {
                $this->location = $mapSize-1;
            }
        }
    }


    public function get_dir(){
        return $this->dir;
    }
    public function set_dir($dir){
        $this->dir = $dir;
    }

    public function set_power($power){ 
        $this->power = $power;
    }
    public function get_power(){
        return $this->power;
    }
    
    public function set_location($location){
        $this->location = $location;
    }


}