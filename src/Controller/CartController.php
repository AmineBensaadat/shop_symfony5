<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Classes\Cart;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Products;

class CartController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/my-cart", name="cart")
     */
    public function index(Cart $cart)
    {
        $compalteCarte = [];
        foreach ($cart->get() as $id => $quantity) {
            $compalteCarte[] = [
                'product' => $this->entityManager->getRepository(Products::class)->findOneById($id),
                'quantity' => $quantity
            ];
        }

        return $this->render('cart/index.html.twig', [
            'cart' => $compalteCarte
        ]);
    }

     /**
     * @Route("/cart/add/{id}", name="add_to_cart")
     */
    public function add(Cart $cart, $id)
    {
        $cart->add($id);
        return $this->redirectToRoute('cart');
    }

         /**
     * @Route("/cart/remove", name="remove_my_cart")
     */
    public function remove(Cart $cart)
    {
        $cart->remove();
        return $this->redirectToRoute('products');
    }
}
