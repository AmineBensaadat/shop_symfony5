<?php

namespace App\Classes;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Entity\Products;
use Doctrine\ORM\EntityManagerInterface;
class Cart {

    private $session;
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager, SessionInterface $session)
    {
        $this->session = $session;
        $this->entityManager = $entityManager;
    }
  
    public function add($id)
    {
        $cart = $this->session->get('cart', []);

        if(!empty($cart[$id])){
            $cart[$id]++;
        }else{
            $cart[$id] = 1;
        }
        $this->session->set('cart',$cart);
    }

    public function get()
    {
        return $this->session->get('cart');
    }

    public function remove()
    {
        return $this->session->remove('cart');
    }

    public function delete($id)
    {
        $cart = $this->session->get('cart', []);
        unset($cart[$id]);
        return $this->session->set('cart', $cart);
    }

    public function decrease($id)
    {
        $cart = $this->session->get('cart', []);
        // check if > 1
        if($cart[$id] > 1 ){
            // new quantiy -1
            $cart[$id]--;
        }else{
            //delete product
            unset($cart[$id]);
        }
        
        return $this->session->set('cart', $cart);
    }
    
    public function getFull(){
        $compalteCarte = [];
        if($this->get()){
            foreach ($this->get() as $id => $quantity) {
                $product_object = $this->entityManager->getRepository(Products::class)->findOneById($id);
                if(!$product_object){
                    $this->delete($id);
                    continue;
                }
                $compalteCarte[] = [
                    'product' => $product_object,
                    'quantity' => $quantity
                ];
            }
        }

        return $compalteCarte;
    }
}