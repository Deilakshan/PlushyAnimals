<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Produits;
use App\Form\Produits1Type;
use App\Repository\CategoryRepository;
use App\Repository\ProduitsRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/renard')]
class RenardController extends AbstractController
{
   /* private $produitsRepository;
    private $categoryRepository;
    
    public function __construct(
        ProduitsRepository $produitsRepository,
        CategoryRepository $categoryRepository,
    )
    {
        $this->produitsRepository = $produitsRepository;
        $this->categoryRepository = $categoryRepository;
    }*/

    #[Route('/', name: 'app_renard_index', methods: ['GET'])]
    public function index(ProduitsRepository $produitsRepository, 
    CategoryRepository $categoryRepository,
    PaginatorInterface $paginatorInterface,
    Request $request): Response
    {   
        $data = $produitsRepository->findAll();
        $produits = $paginatorInterface->paginate(
            $data,
            $request->query->getInt('page', 1),
            6
        );

        return $this->render('renard/index.html.twig', [
            'produits' => $produitsRepository->findAll(),
            'produits' => $produits,
            'categories' => $categoryRepository->findAll()
        ]);
    }


    #[Route('/produits/{category}', name: 'app_produits_category', methods: ['GET'])]
    public function categoryProduits(Request $request, PaginatorInterface $paginatorInterface, 
    Category $category, CategoryRepository $categoryRepository,ProduitsRepository  $produitsRepository): Response
    {
      //  dd( $categoryRepository->findAll());
        $catdata = $produitsRepository->findBy(['category' => $category    ]);
        $produits = $paginatorInterface->paginate(
        // $category->getProduits(),
        $catdata,
        $request->query->getInt('page', 1)
    );
        
        return $this->render('renard/index.html.twig', [
            // 'produits' => $category->getProduits(),
            'produits' => $produits,
            'categories' => $categoryRepository->findAll(),
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
