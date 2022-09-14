<?php
namespace App;

class Game{
    
    public $players;

    public function __construct(int $playersCount,int $diceCount)
    {
        for ($i=0; $i < $playersCount; $i++) { 
            $player = new Player;
            for ($j=0; $j < $diceCount; $j++) { 
                $player->addDice(new Dice);
            }
            $this->players[] = $player;
        }
    }

    public function start()
    {
        while(! $this->hasGameEnded())
        {
            $alreadyDetachedDice = [];

            foreach($this->players as $playerNumber => $player)
            {
                if(! $player->hasDice()) continue;

                
                $player->rollDice();
                $results = $player->getDiceResults();
                
                foreach($results as $diceId => $result)
                {

                    if($result == 6){
                        $player->incrementScore();
                        $player->removeDiceById($diceId);
                        unset($results[$diceId]);
                    }
                    if($result == 1 && !array_key_exists($diceId,$alreadyDetachedDice))
                    {
                        $dice = $player->getDiceById($diceId);
                        $player->removeDiceById($diceId);
                                         
                        if(!$this->hasGameEnded())
                        {
                            $nextAvailablePlayer = $this->getNextAvailablePlayer($playerNumber,$player);
                            $nextAvailablePlayer->addDice($dice);
                        }
                        
                        
                        $alreadyDetachedDice[$diceId] = true;
                        unset($results[$diceId]);
                    }
                }
                
            }
            
         
        }

        $winner = $this->getWinner();
        echo "Winner Score is ".$winner->getScore();
    }

    public function getNextAvailablePlayer($playerNumber,Player $player)
    {
        $nextPlayerNumber = 1;
        while(1){

            if(array_key_exists($playerNumber+$nextPlayerNumber,$this->players) )
            {
                $nextPlayer = $this->players[$playerNumber+$nextPlayerNumber];
                
                if($nextPlayer->hasDice()) return $nextPlayer;

                $nextPlayerNumber++;
            }
            else{
                $playerNumber = 0;
                $nextPlayerNumber = 0;
                continue;
            }

        }
    }
    public function hasGameEnded()
    {
        foreach($this->players as $player)
        {
            if($player->hasDice()) return false;
        }

        return true;
    }

    public function getWinner()
    {
        $winner = $this->players[0];
        $winner_score = $this->players[0]->getScore();
        foreach($this->players as $player)
        {
            if($player->getScore() > $winner_score)
            {
                $winner = $player;
                $winner_score = $player->getScore();
            }   
        }

        return $winner;
    }
}