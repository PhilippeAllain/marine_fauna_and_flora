<?php

namespace App\Controller\Admin;

use App\Entity\Glossary;
use App\Form\GlossaryType;
use App\Repository\GlossaryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route('admin/glossaries', name: 'admin.glossary.')]
class GlossaryController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(Request $request, GlossaryRepository $repository): Response
    {
        $glossaries = $repository->findAll();
        return $this->render('admin/glossary/index.html.twig', [
            'glossaries' => $glossaries,
        ]);
    }

    #[Route('/create', name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $glossary = new Glossary();
        $form = $this->createForm(GlossaryType::class, $glossary);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($glossary);
            $entityManager->flush();
            $this->addFlash('success', 'L\'ajout a bien été éffectué');
            return $this->redirectToRoute('admin.glossary.index');
        }

        return $this->render('admin/glossary/create.html.twig', [
            'form' => $form,
        ]);
    }


    #[Route('/{id}', name: 'edit', methods: ['GET', 'POST'], requirements: ['id' => Requirement::DIGITS])]
    public function edit(Request $request, Glossary $glossary, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(GlossaryType::class, $glossary);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'La modification a bien été éffectuée');
            return $this->redirectToRoute('admin.glossary.index');
        }

        return $this->render('admin/glossary/edit.html.twig', [
            'glossary' => $glossary,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'], requirements: ['id' => Requirement::DIGITS])]
    public function remove(Request $request, Glossary $glossary, EntityManagerInterface $em): Response
    {
        $em->remove($glossary);
        $em->flush();
        $this->addFlash('success', 'La suppression a bien été éffectuée');
        return $this->redirectToRoute('admin.glossary.index',);
    }
}
