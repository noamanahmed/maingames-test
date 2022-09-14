<?php
namespace App;
class Player{
    
    private $dice = [];

    private $score = 0;
    
    public function addDice(Dice $dice)
    {
        $this->dice[$dice->id] = $dice;
        return $this;
    }


    public function removeDice(Dice $dice)
    {
        unset($this->dice[$dice->id]);
        return $this;
    }    

    public function getDiceById(string $id)
    {
        return $this->dice[$id];
    }


    public function removeDiceById(string $id)
    {
        unset($this->dice[$id]);
        return $this;
    }
    
    public function hasDice()
    {
        return count($this->dice) > 0 ? true : false;
    }
    public function getScore()
    {
        return $this->score;
    }

    public function incrementScore()
    {
        $this->score++;
    }

    public function setScore($score)
    {
        $this->score = $score;
        return $this;
    }

    public function rollDice()
    {
        foreach ($this->dice as $dice)
        {
            $dice->roll();
        }
    }

    public function getDiceResults()
    {
        $results = [];

        foreach ($this->dice as $dice)
        {
            $results[$dice->id] = $dice->getFace();
        }

        return $results;
    }
}
 