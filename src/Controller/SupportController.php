<?php

namespace App\Controller;

use App\Entity\Support;
use App\Form\SupportType;
use App\Repository\SupportRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/support')]
class SupportController extends AbstractController
{
    #[Route('/', name: 'app_support_index', methods: ['GET'])]
    public function index(SupportRepository $supportRepository): Response
    {
        return $this->render('support/index.html.twig', [
            'supports' => $supportRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_support_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $support = new Support();
        $form = $this->createForm(SupportType::class, $support);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($support);
            $entityManager->flush();

            return $this->redirectToRoute('app_support_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('support/new.html.twig', [
            'support' => $support,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_support_show', methods: ['GET'])]
    public function show(Support $support): Response
    {
        return $this->render('support/show.html.twig', [
            'support' => $support,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_support_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Support $support, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SupportType::class, $support);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_support_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('support/edit.html.twig', [
            'support' => $support,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_support_delete', methods: ['POST'])]
    public function delete(Request $request, Support $support, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$support->getId(), $request->request->get('_token'))) {
            $entityManager->remove($support);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_support_index', [], Response::HTTP_SEE_OTHER);
    }
}
