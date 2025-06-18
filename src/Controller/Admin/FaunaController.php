<?php

namespace App\Controller\Admin;

use App\Entity\Fauna;
use App\Form\FaunaType;
use App\Repository\FaunaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/faunas', name: 'admin.fauna.')]
#[IsGranted('ROLE_ADMIN')]
class FaunaController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(Request $request, FaunaRepository $repository): Response
    {
        $page = $request->query->getInt('page', 1);
        $limit = 1;
        $faunas = $repository->paginateFaunas($page, $limit);
        return $this->render('admin/fauna/index.html.twig', [
            'faunas' => $faunas,            
        ]);
    }

    #[Route('/create', name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $fauna = new Fauna();
        $form = $this->createForm(FaunaType::class, $fauna);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($fauna);
            $entityManager->flush();
            $this->addFlash('success', 'L\'ajout a bien été éffectué');
            return $this->redirectToRoute('admin.fauna.index');
        }
        return $this->render('admin/fauna/create.html.twig', [
            'form' => $form
        ]);
    }


    #[Route('/{id}', name: 'edit', methods: ['GET', 'POST'], requirements: ['id' => Requirement::DIGITS])]
    public function edit(Fauna $fauna, Request $request, EntityManagerInterface $em)
    {

        $form = $this->createForm(FaunaType::class, $fauna);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->flush();
            $this->addFlash('success', 'La modification a bien été éffectuée');;
            return $this->redirectToRoute('admin.fauna.index');
        }
        return $this->render('admin/fauna/edit.html.twig', [
            'fauna' => $fauna,
            'form' => $form
        ]);

    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'], requirements: ['id' => Requirement::DIGITS])]
    public function remove(Fauna $fauna, EntityManagerInterface $em): Response
    {
        $em->remove($fauna);
        $em->flush();
        $this->addFlash('success', 'La suppression a bien été éffectuée');
        return $this->redirectToRoute('admin.fauna.index');
    }
}
