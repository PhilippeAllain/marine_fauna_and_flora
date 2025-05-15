<?php

namespace App\Controller;

use App\Entity\Faunaspecie;
use App\Form\FaunaspecieType;
use App\Repository\FaunaspecieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route('/admin/faunaspecies', name: 'admin.faunaspecies.')]
final class FaunaspecieController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(FaunaspecieRepository $faunaspecies): Response
    {
        return $this->render('admin/faunaspecie/index.html.twig', [
            'faunaspecies' => $faunaspecies->findAll(),
        ]);
    }

    
    #[Route('/create', name: 'create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $faunaspecie = new Faunaspecie();
        $form = $this->createForm(FaunaspecieType::class, $faunaspecie);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($faunaspecie);
            $entityManager->flush();
            $this->addFlash('success', 'L\'ajout a bien été éffectué');
            return $this->redirectToRoute('admin.faunaspecies.index');
        }
        return $this->render('admin/faunaspecie/create.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/{id}', name: 'edit', methods: ['GET', 'POST'], requirements: ['id' => Requirement::DIGITS])]
    public function edit(Faunaspecie $faunaspecie, Request $request, EntityManagerInterface $em): Response{
        $form = $this->createForm(FaunaspecieType::class, $faunaspecie);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->flush();
            $this->addFlash('success', 'La modification a bien été éffectuée');
            return $this->redirectToRoute('admin.faunaspecies.index');
        }
        return $this->render('admin/faunaspecie/edit.html.twig', [
            'faunaspecie' => $faunaspecie,
            'form' => $form
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'], requirements: ['id' => Requirement::DIGITS])]
    public function remove(Faunaspecie $faunaspecie, EntityManagerInterface $em): Response
    {
        $em->remove($faunaspecie);
        $em->flush();
        $this->addFlash('success', 'La suppression a bien été éffectuée');
        return $this->redirectToRoute('admin.faunaspecies.index');
    }
}
