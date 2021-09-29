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
use Symfony\Contracts\Translation\TranslatorInterface;

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
    public function new(EntityManagerInterface $entityManager, Request $request, TranslatorInterface $translator): Response
    {
        // Autre manière d'optenir l'entityManager:
        // $entityManager = $this->getDoctrine()->getManager();

        // EntityManagerInterface est un service, c'est un objet que Symfony a créé pour nous
        $entity = new Game();
        // Création d'un nouveau formulaire en utilisant la classe GameType
        $form = $this->createForm(GameType::class, $entity);

        // Injecte la requête dans le formulaire pour récupérer les données POST
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($entity); // Prepare la requête
            $entityManager->flush(); // Execute la requête

            $this->addFlash('success', $translator->trans('game.new.success', ['%game%' => $entity->getTitle()]));

            // Redirection 
            return $this->redirectToRoute("app_game_list");
        }
        
        return $this->render("game/new.html.twig", [
            'form' => $form->createView(), // Envoi la vue du formulaire dans la vue twig
        ]);
    }

    /**
     * Requirements indique la valeur attendue, \d+ indique que id doit être un nombre de 1 ou plusieurs chiffres
     * 
     * @Route("/{id}/edit", requirements={"id":"\d+"})
     */
    public function edit(Game $entity, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(GameType::class, $entity);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush(); // L'entité est déjà enregistré dans l'ORM, il n'est pas utile de faire un persist

            $this->addFlash('success', 'Le jeu a bien été modifié');

            return $this->redirectToRoute('app_game_list');
        }

        return $this->render("game/edit.html.twig", [
            'form' => $form->createView(),
            'entity' => $entity,
        ]);
    }

    /**
     * @Route("/{id}/delete", requirements={"id":"\d+"})
     */
    public function delete(Game $entity, Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid("delete".$entity->getId(), $request->get('token'))) {
            $entityManager->remove($entity);
            $entityManager->flush();

            $this->addFlash('success', 'Le jeu a bien été supprimé');

            return $this->redirectToRoute('app_game_list');
        }

        return $this->render("game/delete.html.twig", [
            'entity' => $entity,
        ]);
    }
}