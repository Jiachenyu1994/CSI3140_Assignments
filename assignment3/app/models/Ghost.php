<?php
namespace app\models;

class Ghost{
    private $location;

    public function __construct(){
        $this->location = 0;
    }

    public function getLocation(){
        return $this->location;
    }
    public function setLocation($location){
        $this->location = $location;
    }

}