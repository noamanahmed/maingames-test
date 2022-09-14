<?php

namespace Tests\Unit;

use App\Player;
use App\Dice;
use PHPUnit\Framework\TestCase;

class PlayerTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCanCreatePlayerObjectWithoutException()
    {
        $player = new Player;
        $this->assertTrue(true);
    }


    /**
     * A basic test example.
     *
     * @return void
     */
    public function testPlayerCanAddDice()
    {
        $player = new Player; 
        $dice = new Dice;
        $player->addDice($dice);    
        $this->assertCount(1,$player->getDice());
    }


    /**
     * A basic test example.
     *
     * @return void
     */
    public function testPlayerCanRemoveDice()
    {
        $player = new Player; 
        $dice = new Dice;
        $player->addDice($dice);    
        $this->assertCount(1,$player->getDice());
        $player->removeDice($dice);    
        $this->assertCount(0,$player->getDice());
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testPlayerCanGetDiceById()
    {
        $player = new Player; 
        $dice = new Dice;
        $player->addDice($dice);
        $sameDice = $player->getDiceById($dice->id);    
        $this->assertSame($dice,$sameDice);
    }


    /**
     * A basic test example.
     *
     * @return void
     */
    public function testPlayerCanRemoveDiceById()
    {
        $player = new Player; 
        $dice = new Dice;
        $player->addDice($dice);    
        $this->assertCount(1,$player->getDice());
        $player->removeDiceById($dice->id);    
        $this->assertCount(0,$player->getDice());
    }


    /**
     * A basic test example.
     *
     * @return void
     */
    public function testPlayerCanRollAllHisDice()
    {
        
        $player = new Player; 
        $dice = new Dice;
        $player->addDice($dice);        
        $player->rollDice();
        $results = $player->getDiceResults();        
        $this->assertGreaterThan(0,$results[$dice->id]);
        $this->assertLessThan(7,$results[$dice->id]);


    }


    /**
     * A basic test example.
     *
     * @return void
     */
    public function testPlayerCanIncreaseScore()
    {
        $player = new Player; 
        $dice = new Dice;
        $player->addDice($dice);
        $this->assertEquals(0,$player->getSCore());        
        $player->incrementScore();
        $this->assertEquals(1,$player->getSCore());        
        
    }
}
