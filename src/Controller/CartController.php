<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Classes\Cart;

class CartController extends AbstractController
{
    /**
     * @Route("/my-cart", name="cart")
     */
    public function index(Cart $cart)
    {
        dd($cart->get());
        return $this->render('cart/index.html.twig');
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
