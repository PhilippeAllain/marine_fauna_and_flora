<?php

namespace App\Controller;

use App\Entity\Floraspecie;
use App\Form\FloraspecieType;
use App\Repository\FloraspecieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/floraspecies', name: 'admin.floraspecies.')]
#[IsGranted('ROLE_ADMIN')]
final class FloraspecieController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(Request $request,FloraspecieRepository $floraspecies): Response
    {
        $page = $request->query->getInt('page', 1);
        $limit = 2; // Number of items per page
        $floraspecies = $floraspecies->paginateFloraspecies($page, $limit);
        $maxPage = ceil($floraspecies->getTotalItemCount() / $limit);
        //dd($species->count());
        return $this->render('admin/floraspecie/index.html.twig', [
            'floraspecies' => $floraspecies,
            'maxPage' => $maxPage,
            'page' => $page,
        ]);
    }

    #[Route('/create', name: 'create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $floraspecie = new Floraspecie();
        $form = $this->createForm(FloraspecieType::class, $floraspecie);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($floraspecie);
            $entityManager->flush();
            $this->addFlash('success', 'L\'ajout a bien été éffectué');
            return $this->redirectToRoute('admin.floraspecies.index');
        }
        return $this->render('admin/floraspecie/create.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/{id}', name: 'edit', methods: ['GET', 'POST'], requirements: ['id' => Requirement::DIGITS])]
    public function edit(Floraspecie $floraspecie, Request $request, EntityManagerInterface $em): Response{
        $form = $this->createForm(FloraspecieType::class, $floraspecie);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->flush();
            $this->addFlash('success', 'La modification a bien été éffectuée');
            return $this->redirectToRoute('admin.floraspecies.index');
        }
        return $this->render('admin/floraspecie/edit.html.twig', [
            'floraspecie' => $floraspecie,
            'form' => $form
        ]);
    }

        #[Route('/{id}', name: 'delete', methods: ['DELETE'], requirements: ['id' => Requirement::DIGITS])]
    public function remove(Floraspecie $floraspecie, EntityManagerInterface $em): Response
    {
        $em->remove($floraspecie);
        $em->flush();
        $this->addFlash('success', 'La suppression a bien été éffectuée');
        return $this->redirectToRoute('admin.floraaspecies.index');
    }
}
