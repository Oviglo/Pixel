<?php 

namespace App\Controller;

use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route(path:'/api')]
class APIController extends AbstractController
{
    #[Route('/game.{_format<json|xml|csv|yaml>}')]
    // #[Route('/game.{_format}', requirements: ['_format' => 'json|xml|csv|yaml'])]
    public function game(string $_format, GameRepository $gameRepository, SerializerInterface $serializer, Request $request): Response
    {
        $games = $gameRepository->findFiltered(
            search: $request->get('s')
        );

        // return new JsonResponse($games);

        return new Response(
            content: $serializer->serialize($games, $_format, ['json_encode_options' => \JSON_PRETTY_PRINT]),
            headers: ['content-type' => 'text/'.$_format]
        );
    }
}