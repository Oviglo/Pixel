<?php 

namespace App\Controller;

use App\Entity\Game;
use App\Form\GameType;
use App\Repository\GameRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Définie un prefix pour toutes les routes de ce controleur
 * 
 * @Route("/game")
 */
class GameController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function list(GameRepository $gameRepository): Response 
    {
        $entities = $gameRepository->findAll(); // retourne tous les jeux

        return $this->render("game/list.html.twig", [
            'entities' => $entities,
        ]);
    }

    /**
     * @Route("/new")
     */
    public function new(EntityManagerInterface $entityManager, Request $request): Response
    {
        // EntityManagerInterface est un service, c'est un objet que Symfony a créé pour nous
        $entity = new Game();
        // Création d'un nouveau formulaire en utilisant la classe GameType
        $form = $this->createForm(GameType::class, $entity);

        // Injecte la requête dans le formulaire pour récupérer les données POST
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($entity); // Prepare la requête
            $entityManager->flush(); // Execute la requête
        }
        
        return $this->render("game/new.html.twig", [
            'form' => $form->createView(), // Envoi la vue du formulaire dans la vue twig
        ]);
    }
}