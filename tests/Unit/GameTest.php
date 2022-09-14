<?php

namespace Tests\Unit;

use App\Game;
use PHPUnit\Framework\TestCase;

class GameTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCanCreateGameObjectWithoutException() : void
    {
        $game = new Game(3,3);
        $this->assertTrue(true);
    }


    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCanRunGameWithoutException() : void
    {
        $game = new Game(3,3);
        $game->start();
        $this->assertTrue(true);
    }


    /**
     * A basic test example.
     *
     * @return void
     */
    public function testRunGameWithInputsFromTask() : void
    {
        $alreadyDetachedDice = [];
        $game = new Game(3,4);
        foreach($game->players as $player)
        {
            $player->rollDice();
            
        }
        $alreadyDetachedDice = [];
        $game->players[0]->setDiceResults([3,6,1,3]);
        $game->players[1]->setDiceResults([2,4,5,5]);
        $game->players[2]->setDiceResults([1,2,5,6]);

        foreach($game->players as $playerNumber => $player)
        {
            $results = $player->getDiceResults();
            $game->evaluate($results,$player,$playerNumber,$alreadyDetachedDice);                
        }

        $this->assertEquals(array_values($game->players[0]->getDiceResults()),[
            3,3,1 
        ]);
        $this->assertEquals(array_values($game->players[1]->getDiceResults()),[
            2,4,5,5,1
        ]);
        $this->assertEquals(array_values($game->players[2]->getDiceResults()),[
            2,5
        ]);

        $alreadyDetachedDice = [];
        $game->players[0]->setDiceResults([1,2,6]);
        $game->players[1]->setDiceResults([4,3,1,3,3]);
        $game->players[2]->setDiceResults([1,6]);

            
        foreach($game->players as $playerNumber => $player)
        {
            $results = $player->getDiceResults();
            $game->evaluate($results,$player,$playerNumber,$alreadyDetachedDice);                
        }

        $this->assertEquals(array_values($game->players[0]->getDiceResults()),[
            2,1
        ]);
        $this->assertEquals(array_values($game->players[1]->getDiceResults()),[
            4,3,3,3,1
        ]);
        $this->assertEquals(array_values($game->players[2]->getDiceResults()),[
            1
        ]);

        $alreadyDetachedDice = [];
        $game->players[0]->setDiceResults([6,1]);
        $game->players[1]->setDiceResults([2,5,6,4,6]);
        $game->players[2]->setDiceResults([1]);

            
        foreach($game->players as $playerNumber => $player)
        {

            if(! $player->hasDice()) { 
                continue;
            }
            
            $results = $player->getDiceResults();
            $game->evaluate($results,$player,$playerNumber,$alreadyDetachedDice);                
        }

        
        $this->assertEquals(array_values($game->players[0]->getDiceResults()),[
            1
        ]);
        $this->assertEquals(array_values($game->players[1]->getDiceResults()),[
            2,5,4,1
        ]);
        $this->assertEquals(array_values($game->players[2]->getDiceResults()),[
            
        ]);

        $alreadyDetachedDice = [];
        $game->players[0]->setDiceResults([1]);
        $game->players[1]->setDiceResults([3,4,5,5]);        

            
        foreach($game->players as $playerNumber => $player)
        {
            
            if(! $player->hasDice()) { 
                continue;
            }
            
            $results = $player->getDiceResults();
            $game->evaluate($results,$player,$playerNumber,$alreadyDetachedDice);                
        }


        $this->assertEquals(array_values($game->players[0]->getDiceResults()),[
            
        ]);
        $this->assertEquals(array_values($game->players[1]->getDiceResults()),[
            3,4,5,5,1
        ]);
        $this->assertEquals(array_values($game->players[2]->getDiceResults()),[
            
        ]);

        $this->assertEquals($game->getWinner()->id,$game->players[0]->id);
        $this->assertEquals(3,$game->getWinner()->getScore());
    }
}
