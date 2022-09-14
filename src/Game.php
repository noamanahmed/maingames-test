<?php

namespace App;

use InvalidArgumentException;

/**
 * This class is responsible for game
 */
class Game
{
    
    public $players;

    /**
     * Constructor
     *
     * @param   int  $playersCount  [$playersCount description]
     * @param   int  $diceCount     [$diceCount description]
     *
     * @return  [type]              [return description]
     */
    public function __construct(int $playersCount,int $diceCount)
    {
        if($playersCount == 0 || $diceCount == 0) throw new InvalidArgumentException("Number of Players or Dice must be greater than zero");
        for ($i=0; $i < $playersCount; $i++) { 
            $player = new Player;
            for ($j=0; $j < $diceCount; $j++) { 
                $player->addDice(new Dice);
            }
            $this->players[] = $player;
        }
    }

    /**
     * Start the game
     *
     * @return  void
     */
    public function start() : void
    {
        while(! $this->hasGameEnded())
        {
            $alreadyDetachedDice = [];

            foreach($this->players as $playerNumber => $player)
            {
                if(! $player->hasDice()) { 
                    continue;
                }

                $player->rollDice();
                $results = $player->getDiceResults();
                $this->evaluate($results,$player,$playerNumber,$alreadyDetachedDice);    
                
            }
            
        }

    }

    public function evaluate($results,$player,$playerNumber,&$alreadyDetachedDice)
    {
        
        foreach($results as $diceId => $result)
        {

            if($result == 6) {
                $player->incrementScore();
                $player->removeDiceById($diceId);
                unset($results[$diceId]);
            }
            if($result == 1 && !array_key_exists($diceId, $alreadyDetachedDice)) {
                $dice = $player->getDiceById($diceId);
                $player->removeDiceById($diceId);
                                
                if(!$this->hasGameEnded()) {
                    $nextAvailablePlayer = $this->getNextAvailablePlayer($playerNumber, $player);
                    $nextAvailablePlayer->addDice($dice);
                }
                
                
                $alreadyDetachedDice[$diceId] = true;
                unset($results[$diceId]);
            }
        }
    }

    /**
     * A function to get the next available player
     *
     * @param   [int]  $playerNumber  [$playerNumber description]
     * @param   Player  $player        [$player description]
     *
     * @return  Player                 [return description]
     */
    public function getNextAvailablePlayer($playerNumber,Player $player)
    {
        $nextPlayerNumber = 1;
        while(1){

            if(array_key_exists($playerNumber+$nextPlayerNumber, $this->players) ) {
                $nextPlayer = $this->players[$playerNumber+$nextPlayerNumber];
                
                return $nextPlayer;

                $nextPlayerNumber++;
            }
            else{
                $playerNumber = 0;
                $nextPlayerNumber = 0;
                continue;
            }

        }
    }
    /**
     * Check if game has ended by checking if each player has dice
     *
     * @return  [type]  [return description]
     */
    public function hasGameEnded()
    {
        foreach($this->players as $player)
        {
            if($player->hasDice()) { return false;
            }
        }

        return true;
    }

    /**
     * Get the winner
     *
     * @return  Player
     */
    public function getWinner()
    {
        $winner = $this->players[0];
        $winner_score = $this->players[0]->getScore();
        foreach($this->players as $player)
        {
            if($player->getScore() > $winner_score) {
                $winner = $player;
                $winner_score = $player->getScore();
            }   
        }

        return $winner;
    }
    
}