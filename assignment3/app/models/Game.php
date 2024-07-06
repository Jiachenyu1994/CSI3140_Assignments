<?php
namespace app\models;

class Game{
    private $pacman;
    private $ghost;
    private $map;
    private $score;
    private $size;

    public function __construct(Pacman $pacman,Ghost $ghost){
            $this->pacman = $pacman;
            $this->ghost=$ghost;
            $this->size=0;
            $this->score= 0;
            $this->map = $this->makeMap($this->size);
    }

    public function makeMap($size){
        $this->size=$size;
        $map = [];
        if ($size == '') {
            return $map;
        }
        if ($size < 3) {
            return $map;
        }

        for ($i = 0; $i < $size; $i++) {
            if ($i == floor($size / 3)) {
                array_push($map,"C");
                // Clocation = i;
                $this->pacman->set_location($i);
            } else if ($i == floor($size / 2)) {
                array_push($map,"@");
            } else if ($i == $size - 1) {
                array_push($map,"^.");
                $this->ghost->setLocation($i);
            } else {
                array_push($map,".");
            }
        }
        return $map;
    }

}