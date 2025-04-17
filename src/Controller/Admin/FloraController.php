<?php

namespace App\Controller\Admin;

use App\Entity\Flora;
use App\Form\FloraType;
use App\Repository\FloraRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route('/admin/floras', name: 'admin.flora.')]
class FloraController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(Request $request, FloraRepository $repository): Response
    {
        $floras = $repository->findAll();
        return $this->render('admin/flora/index.html.twig', [
            'floras' => $floras,
        ]);
    }

    #[Route('/create', name: 'create')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $flora = new Flora();
        $form = $this->createForm(FloraType::class, $flora);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($flora);
            $em->flush();
            $this->addFlash('success', 'L\'ajout a bien été éffectué');
            return $this->redirectToRoute('admin.flora.index');
        }
        return $this->render('admin/flora/create.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/{id}', name: 'edit', methods: ['GET', 'POST'], requirements: ['id' => Requirement::DIGITS])]
    public function edit(Flora $flora, Request $request, EntityManagerInterface $em): Response{
        $form = $this->createForm(FloraType::class, $flora);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->flush();
            $this->addFlash('success', 'La modification a bien été éffectuée');
            return $this->redirectToRoute('admin.flora.index');
        }
        return $this->render('admin/flora/edit.html.twig', [
            'flora' => $flora,
            'form' => $form
        ]);

    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'], requirements: ['id' => Requirement::DIGITS])]
    public function remove(Flora $flora, EntityManagerInterface $em): Response
    {
        $em->remove($flora);
        $em->flush();
        $this->addFlash('success', 'La suppression a bien été éffectuée');
        return $this->redirectToRoute('admin.flora.index');
    }
}
