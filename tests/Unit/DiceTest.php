<?php

namespace Tests\Unit;

use App\Dice;
use PHPUnit\Framework\TestCase;

class DiceTest extends TestCase
{
    /**
     * Can create object of dice
     *
     * @return void
     */
    public function testCanCreateDiceObjectWithoutException() : void
    {
        $dice = new Dice;
        $this->assertTrue(true);
    }

    /**
     * Check if we can roll dice
     *
     * @return  void
     */
    public function testCanRunRollDice() : void
    {
        $dice = new Dice;
        $dice->roll();
        $this->assertIsInt($dice->getFace());
    }

}
