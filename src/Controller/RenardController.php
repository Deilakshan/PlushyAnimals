<?php

namespace App\Controller;

use App\Entity\Produits;
use App\Form\Produits1Type;
use App\Repository\ProduitsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/renard')]
class RenardController extends AbstractController
{
    #[Route('/', name: 'app_renard_index', methods: ['GET'])]
    public function index(ProduitsRepository $produitsRepository): Response
    {
        return $this->render('renard/index.html.twig', [
            'produits' => $produitsRepository->findAll(),
        ]);
    }


    #[Route('/{id}', name: 'app_renard_show', methods: ['GET'])]
    public function show(Produits $produit): Response
    {
        return $this->render('renard/show.html.twig', [
            'produit' => $produit,
        ]);
    }

}
