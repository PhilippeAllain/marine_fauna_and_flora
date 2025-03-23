<?php

namespace App\Controller;

use App\Entity\Fauna;
use App\Form\FaunaType;
use App\Repository\FaunaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class FaunaController extends AbstractController
{
    #[Route('/fauna', name: 'fauna.index')]
    public function index(Request $request, FaunaRepository $repository, EntityManagerInterface $em): Response
    {
        $faunas = $repository->findAll();
        return $this->render('fauna/index.html.twig', [
            'faunas' => $faunas,
        ]);
    }

    #[Route('/fauna/{id}-{slug}', name: 'fauna.show', requirements: ['id' => '\d+', 'slug' => '[a-z0-9-]+'])]
    public function show(Request $request, int $id, string $slug, FaunaRepository $repository): Response
    {
        $fauna = $repository->find($id);
        if ($fauna->getSlug() !== $slug) {
            return $this->redirectToRoute('fauna.show', [
                'id' => $fauna->getId(),
                'slug' => $fauna->getSlug()
            ]);
        }
        return $this->render('fauna/show.html.twig', [
            'fauna' => $fauna,
            
        ]);
    }

    #[Route('/faunas/{id}/edit', name: 'fauna.edit', methods: ['GET', 'POST'])]
    public function edit(Fauna $fauna, Request $request, EntityManagerInterface $em): Response{
        $form = $this->createForm(FaunaType::class, $fauna);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->flush();
            $this->addFlash('success', 'La modification a bien été éffectuée');
            return $this->redirectToRoute('fauna.index');
        }
        return $this->render('fauna/edit.html.twig', [
            'fauna' => $fauna,
            'form' => $form
        ]);

    }
    #[Route('/faunas/create', name: 'fauna.create')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $fauna = new Fauna();
        $form = $this->createForm(FaunaType::class, $fauna);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($fauna);
            $em->flush();
            $this->addFlash('success', 'L\'ajout a bien été éffectué');
            return $this->redirectToRoute('fauna.index');
        }
        return $this->render('fauna/create.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/faunas/{id}/delete', name: 'fauna.delete', methods: ['DELETE'])]
    public function remove(Fauna $fauna, EntityManagerInterface $em): Response
    {
        $em->remove($fauna);
        $em->flush();
        $this->addFlash('success', 'La suppression a bien été éffectuée');
        return $this->redirectToRoute('fauna.index');
    }
}
