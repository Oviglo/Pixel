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
    /**
     * @Route("/")
     */
    public function home(): Response
    {
        // retourne le rendu de la vue twig
        return $this->render("app/home.html.twig", [
            'name' => 'Eric', // envoi un paramètre à la vue
        ]);
    }

    /**
     * @Route("search-address")
     */
    public function searchAddress(Request $request, AddressApiInterface $addressApi): Response
    {
        $search = $request->get('search', '');
        $addresses = $addressApi->searchAddress($search);

        return new JsonResponse($addresses);
    }
}