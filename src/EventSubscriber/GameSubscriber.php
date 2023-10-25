<?php 

namespace App\EventSubscriber;

use App\Event\GameEvent;
use App\Event\GameEvents;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

class GameSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            GameEvents::GAME_ADDED => 'onGameAdded',
        ];
    }

    public function __construct(private MailerInterface $mailer)
    {}

    public function onGameAdded(GameEvent $event): void 
    {
        $game = $event->getGame();

        // var_dump($game->getName());
        // exit;

        $email = (new TemplatedEmail())
            ->from(new Address('noreply@pixel.com', 'Pixel Notification'))
            ->to(new Address('admin@pixel.com', 'Admin Pixel'))
            ->subject('Nouvelle fiche de jeu')
            //->html('Une nouvelle fiche de jeu a été ajoutée '. $game->getName())
            ->htmlTemplate('mail/game_added.html.twig')
            ->context([
                'entity' => $game,
            ])
        ;

        $this->mailer->send($email);
    }
}