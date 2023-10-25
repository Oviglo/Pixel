<?php 

namespace App\Event;

class GameEvents
{
    /**
     * La fiche d'un jeu vient d'être ajoutée
     * 
     * @Event(App\Event\GameEvent)
     */
    public const GAME_ADDED = 'app.game.added';
}