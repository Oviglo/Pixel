<?php 

namespace App\Controller;

use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api')]
class APIController extends AbstractController
{
    #[Route('/game.{_format<json|xml|csv|yaml>}')]
    // #[Route('/game.{_format}', requirements: ['_format' => 'json|xml|csv|yaml'])]
    public function game(string $_format, GameRepository $gameRepository, SerializerInterface $serializer): Response
    {
        $games = $gameRepository->findFiltered('1');

        /*
        return new JsonResponse($games);
        */

        // Utiliser l'attribut Ignore pour éviter les erreurs circulaires (boucle infinie) et d'afficher des données confidentielles
        return new Response(
            content: $serializer->serialize($games, $_format),
            headers: ['content-type' => 'text/'. $_format]
        );
    }
}