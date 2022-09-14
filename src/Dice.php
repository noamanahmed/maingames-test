<?php

namespace App;

class Dice
{
    private $face;
    public $id;

    public function __construct()
    {
        $this->id = uniqid();   
    }
    public function roll()
    {
        $this->face = rand(1, 6);
        return $this;
    }

    public function reset()
    {
        $this->face = 0;
        return $this;
    }

    public function getFace()
    {
        return $this->face;
    }

    public function setFace($face)
    {
        $this->face = $face;
        return $this;
    }
}