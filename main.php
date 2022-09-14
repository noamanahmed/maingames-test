<?php

require 'vendor/autoload.php';


$game = new App\Game(3,4);
$game->start();
$winner = $game->getWinner();
echo "Winner Score is ".$winner->getScore();