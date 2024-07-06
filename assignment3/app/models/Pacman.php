<?php
namespace app\models;

class Pacman{
    private $location;
    private $power;
    public function __construct(){
        $this->location = 0;
        $this->power = 0;
    }

    public function get_location(){
        return $this->location;
    }
    public function get_power(){
        return $this->power;
    }

    public function set_power($power){ 
        $this->power = $power;
    }
    public function set_location($location){
        $this->location = $location;
    }


}