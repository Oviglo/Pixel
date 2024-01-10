<?php

namespace App\Controller;

use App\Address\AddressApiInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    #[Route(path:'/')]
    public function home(): Response
    {
        // return new Response('Hello world');

        return $this->render('app/home.html.twig');
    }

    #[Route('/address')]
    public function address(Request $request, AddressApiInterface $addressApi): JsonResponse
    {
        $search = $request->get('search', '');
        $result = $addressApi->search($search);

        return (new JsonResponse($result))
            ->setEncodingOptions(JsonResponse::DEFAULT_ENCODING_OPTIONS | JSON_PRETTY_PRINT)
        ;
    }
}