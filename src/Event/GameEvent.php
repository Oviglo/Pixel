<?php 

namespace App\Event;

use App\Entity\Game;
use Symfony\Contracts\EventDispatcher\Event;

class GameEvent extends Event
{
    public function __construct(private Game $game)
    {}

    public function getGame(): Game 
    {
        return $this->game;
    }
}