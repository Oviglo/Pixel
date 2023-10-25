<?php 

namespace App\EventSubscriber;

use App\Entity\Login;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\AuthenticationEvents;
use Symfony\Component\Security\Core\Event\AuthenticationSuccessEvent;

class LoginSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            AuthenticationEvents::AUTHENTICATION_SUCCESS => 'onAuthenticationSuccess',          
        ];
    }

    public function __construct(private EntityManagerInterface $em)
    {}

    public function onAuthenticationSuccess(AuthenticationSuccessEvent $event): void 
    {
        $user = $event->getAuthenticationToken()->getUser();
        
        $login = (new Login())
            ->setUser($user)
            ->setDate(new \DateTime())
        ;  

        $this->em->persist($login);
        $this->em->flush();
    }
}