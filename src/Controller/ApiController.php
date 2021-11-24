<?php

namespace App\Controller;

use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/api")
 */
class ApiController extends AbstractController
{
    /**
     * @Route("/game.{_format}", defaults={"_format": "json"})
     */
    public function game(string $_format, Request $request, GameRepository $gameRepository, SerializerInterface $serializer): Response
    {
        $page = $request->get('p', 1);
        $search = $request->get('s', '');
        $itemCount = 40;

        $entities = $gameRepository->findPagination($page, $itemCount, $search);

        return new Response(
            $serializer->serialize($entities, $_format, ['json_encode_options' => \JSON_PRETTY_PRINT]), 
            Response::HTTP_OK, 
            ['content-type' => 'text/'.$_format]
        );
    }
}
