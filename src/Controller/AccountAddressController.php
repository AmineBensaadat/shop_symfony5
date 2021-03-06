<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\AddressType;
use App\Entity\Address;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Classes\Cart;

class AccountAddressController extends AbstractController
{
    private $entityManager;

    //call Doctrine
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;   
    }
    
    /**
     * @Route("/account/addresses", name="account_address")
     */
    public function index(): Response
    {
        return $this->render('account/address.html.twig');
    }

     /**
     * @Route("/account/addresses/add", name="account_address_add")
     */
    public function add(Cart $cart , Request $request): Response
    {
        $address = new Address();
        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $address->setUser($this->getUser());
            // passe entity to doctrine
            $this->entityManager->persist($address);

            // set data into table
            $this->entityManager->flush();

            if($cart->get()){
                return  $this->redirectToRoute('order');
            }else{
                // rederct to root
                return $this->redirectToRoute('account_address');
            }
        }
        return $this->render('account/address_form.html.twig', [
            'form' => $form->createView()
        ]);
    }

     /**
     * @Route("/account/addresses/edit/{id}", name="account_address_edit")
     */
    public function edit(Request $request, $id)
    {
        $address = $this->entityManager->getRepository(Address::class)->findOneById($id);
        if(!$address || $address->getUser() != $this->getUser()){
            return $this->redirectToRoute('account_address');
        }
        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            // set data into table
            $this->entityManager->flush();

            // rederct to root
            return $this->redirectToRoute('account_address');
        }
        return $this->render('account/address_form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    
     /**
     * @Route("/account/addresses/delete/{id}", name="account_address_delete")
     */
        public function delete(Request $request, $id)
        {
            $address = $this->entityManager->getRepository(Address::class)->findOneById($id);
            if($address && $address->getUser() == $this->getUser()){
                // set data into table
                $this->entityManager->remove($address);
                $this->entityManager->flush();
            }
            // rederct to root
            return $this->redirectToRoute('account_address');
        }
}
