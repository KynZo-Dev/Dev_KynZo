<?php

namespace App\Controller;

use App\Entity\Projets;
use App\Form\ProjetsType;
use App\Repository\ProjetsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/projets')]
class ProjetsController extends AbstractController
{
    #[Route('/', name: 'projets_index', methods: ['GET'])]
    public function index(ProjetsRepository $projetsRepository): Response
    {
        return $this->render('projets/index.html.twig', [
            'projets' => $projetsRepository->findBy([], ['CreatedAt' => 'DESC']),
        ]);
    }

    #[Route('/new', name: 'projets_new', methods: ['GET','POST'])]
    public function new(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $projet = new Projets();
        $form = $this->createForm(ProjetsType::class, $projet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($projet);
            $entityManager->flush();

            $this->addFlash('success', 'Projet créé avec succès');

            return $this->redirectToRoute('projets_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('projets/new.html.twig', [
            'projet' => $projet,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'projets_show', methods: ['GET'])]
    public function show(Projets $projet): Response
    {
        return $this->render('projets/show.html.twig', [
            'projet' => $projet,
        ]);
    }

    #[Route('/{id}/edit', name: 'projets_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Projets $projet): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $form = $this->createForm(ProjetsType::class, $projet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Projet modifié avec succès');

            return $this->redirectToRoute('projets_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('projets/edit.html.twig', [
            'projet' => $projet,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'projets_delete', methods: ['POST'])]
    public function delete(Request $request, Projets $projet): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        
        if ($this->isCsrfTokenValid('delete'.$projet->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($projet);
            $entityManager->flush();
            
            $this->addFlash('info', 'Projet supprimé avec succès');
        }

        return $this->redirectToRoute('projets_index', [], Response::HTTP_SEE_OTHER);
    }
}
