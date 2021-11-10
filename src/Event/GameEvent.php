<?php 

namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;
use App\Entity\Game;

class GameEvent extends Event
{
    /**
     * @var Game
     */
    private $game;

    public function __construct(Game $game) 
    {
        $this->game = $game;
    }

    public function getGame(): Game
    {
        return $this->game;
    }
 
    public function setGame(Game $game): self
    {
        $this->game = $game;

        return $this;
    }
}