<?php

namespace App\Controller;

use App\Entity\Game;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    // Injection de dépendance: SF va m'envoyer les objets dont j'ai besoin en paramètre
    #[Route('/game', name: 'app_game')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $entity = new Game();
        $entity->setName('Metroid');
        $entity->setDescription('');

        // Indique à Doctrine de prendre en charge cet objet
        // Prepare la requête
        $entityManager->persist($entity);

        $entityManager->flush(); // Exécute la requête

        return $this->render('game/index.html.twig', []);
    }
}
