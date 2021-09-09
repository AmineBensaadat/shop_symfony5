<?php

namespace App\Controller;

use App\Entity\Products;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\SearchType;
use App\Classes\Search;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    /**
     * @Route("/products", name="products")
     */
    public function index(Request $request)
    {
             $search = new Search();
              // create form  depend on entity
              $form = $this->createForm(SearchType::class, $search);

              // get requests
               $form->handleRequest($request);
      
              // form validation 
              if($form->isSubmitted() && $form->isValid()) {
                $products = $this->entityManager->getRepository(Products::class)->findWithSearch($search);
              }else{
                $products = $this->entityManager->getRepository(Products::class)->findAll();
              }
        
        return $this->render('product/index.html.twig', [
            'products' => $products,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/product/{slug}", name="product")
     */
    public function show($slug): Response
    {
        $product = $this->entityManager->getRepository(Products::class)->findOneBySlug($slug);
        if(!$product){
            return $this->redirectToRoute('products');
        }
        return $this->render('product/show.html.twig', [
            'product' => $product
        ]);
    }

}
