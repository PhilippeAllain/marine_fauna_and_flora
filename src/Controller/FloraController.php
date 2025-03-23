<?php

namespace App\Controller;

use App\Repository\FloraRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class FloraController extends AbstractController
{
    #[Route('/flora', name: 'flora.index')]
    public function index(Request $request, FloraRepository $repository): Response
    {
        $floras = $repository->findAll();
        return $this->render('flora/index.html.twig', [
            'floras' => $floras,
        ]);
    }

    #[Route('/flora/{id}', name: 'flora.show', requirements: ['id' => '\d+'])]
    public function show(int $id, Request $request, FloraRepository $repository): Response
    {
        
        return $this->render('flora/show.html.twig', [
            'id' => $id,
        ]);
    }
}
