<?php

namespace App\Controller;

use App\Entity\Game;
use App\Repository\GameRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    #[Route('/game')]
    public function index(GameRepository $gameRepository): Response
    {
        $entities = $gameRepository->findAll(); // SELECT * FROM game

        return $this->render('game/index.html.twig', [
            'entities' => $entities, // On envois le resultat dans la vue
        ]);
    }

    // Injection de dépendance: SF va m'envoyer les objets dont j'ai besoin en paramètre
    #[Route('/game/new')]
    public function new(EntityManagerInterface $entityManager): Response
    {
        $entity = new Game();
        $entity->setName('The Legend Of Zelda');
        $entity->setDescription('');

        // Indique à Doctrine de prendre en charge cet objet
        // Prepare la requête
        $entityManager->persist($entity);

        $entityManager->flush(); // Exécute la requête

        return $this->render('game/index.html.twig', []);
    }
}
