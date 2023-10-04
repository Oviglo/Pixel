<?php

namespace App\Controller;

use App\Entity\Game;
use App\Form\GameType;
use App\Repository\GameRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    #[Route('/game')]
    public function index(GameRepository $gameRepository): Response
    {
        $entities = $gameRepository->findAlpha();

        return $this->render('game/index.html.twig', [
            'entities' => $entities,
        ]);
    }

    #[Route('/game/{id<\d+>}')]
    public function show(Game $entity): Response
    {
        return $this->render('game/show.html.twig', [
            'entity' => $entity,
        ]);
    }

    // Injection de dépendance: SF va m'envoyer les objets dont j'ai besoin en paramètre
    #[Route('/game/new')]
    #[IsGranted('ROLE_USER')]
    public function new(EntityManagerInterface $entityManager, Request $request): Response
    {
        $entity = new Game();
        // $entity->setName('Tetris');
        // $entity->setDescription('');

        // Chargement du formulaire et envois de l'entité game pour initialiser les données
        $form = $this->createForm(GameType::class, $entity);
        // Permet d'envoyer les données POST dans le formulaire
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Indique à Doctrine de prendre en charge cet objet
            // Prepare la requête
            $entityManager->persist($entity);

            $entityManager->flush(); // Exécute la requête

            return $this->redirectToRoute('app_game_index'); // redirection vers la liste des jeux
        }

        return $this->render('game/new.html.twig', [
            'gameForm' => $form->createView(), // Envois du formulaire dans la vue
        ]);
    }

    // {id} est un paramètre qui est un nombre de 1 ou plusieurs chiffres
    // Grâce au Param Converter, Symfony va faire automatiquement une requête pour récupérer le jeu en fonction de l'id
    #[Route('/game/{id<\d+>}/edit')]
    public function edit(Game $entity, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(GameType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('app_game_index');
        }

        return $this->render('game/edit.html.twig', [
            'gameForm' => $form->createView(),
        ]);
    }

    #[Route('/game/{id<\d+>}/delete')]
    public function delete(Game $entity, Request $request, EntityManagerInterface $em): Response
    {
        if ($request->getMethod() === Request::METHOD_POST) {
            if ($this->isCsrfTokenValid('delete_game', $request->get('_token'))) {

                $em->remove($entity);
                $em->flush();

                return $this->redirectToRoute('app_game_index');
            }
        }

        return $this->render('game/delete.html.twig', [
            'entity' => $entity,
        ]);
    }
}
