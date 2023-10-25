<?php 

namespace App\Event;

class GameEvents
{
    /**
     * Lorsqu'une fiche de jeu est ajoutée
     * 
     * @Event("App\Event\GameEvent")
     */
    public const GAME_ADDED = 'app.game.added';
}