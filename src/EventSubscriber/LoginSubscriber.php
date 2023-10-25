<?php 

namespace App\EventSubscriber;

use App\Entity\Login;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
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

    public function __construct(private EntityManagerInterface $em, private RequestStack $requestStack)
    {}

    public function onAuthenticationSuccess(AuthenticationSuccessEvent $event): void 
    {
        $user = $event->getAuthenticationToken()->getUser();

        //var_dump($user->getUsername() . " s'est connecté");
        //exit;

        $login = (new Login())
            ->setUser($user)
            ->setDate(new \DateTime)
        ;

        $this->em->persist($login);
        $this->em->flush();

        // Pour récupérer l'adresse IP de l'utilisateur
        $request = $this->requestStack->getCurrentRequest();
        $ip = $request->getClientIp();
    }
}