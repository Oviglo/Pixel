<?php

namespace App\Controller;

use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api')]
class APIController extends AbstractController
{
    #[Route('/game.{_format<json|yaml|xml|csv>}')]
    public function game(string $_format, GameRepository $gameRepository, SerializerInterface $serializer, Request $request): Response
    {
        $games = $gameRepository->findFiltered(
            search: $request->get('search', '')
        );

        // Utiliser l'attribut "Ignore" dans les entité pour ne pas afficher de données confidentielles ou pour éviter des erreurs "circulaires" (boucle infinie)
        return new Response(
            content: $serializer->serialize($games, $_format),
            headers: ['content-type' => 'text/' . $_format]
        );
    }
}