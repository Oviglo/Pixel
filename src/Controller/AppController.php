<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}