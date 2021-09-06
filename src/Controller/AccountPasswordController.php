<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class AccountPasswordController extends AbstractController
{

    private $entityManager;

    //call Doctrine
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;   
    }
    
    /**
     * @Route("/account/password/update", name="account_password_update")
     */
    public function index( Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $notidication = null;
        $user = $this->getUser($request);
        $form = $this->createForm(ChangePasswordType::class, $user);
         // get requests
         $form->handleRequest($request);
                // form validation 
                if($form->isSubmitted() && $form->isValid()) {
                    $old_pwd = $form->get('old_password')->getData();
                
                    if($encoder->isPasswordValid($user, $old_pwd)){
                        $new_pwd = $form->get('new_password')->getData();
                        $user->setPassword($new_pwd);
                        
                        // passe entity to doctrine
                        $this->entityManager->persist($user);

                        // set data into table
                        $this->entityManager->flush();
                    }

                    //get data from the from
                    $user = $form->getData();
        
                        // hash Password
                        $password = $user->getPassword();
        
                        $encoded = $encoder->encodePassword($user, $password);
                        $user->setPassword($encoded);
        
                    // set data into table
                    $this->entityManager->flush();

                    $notidication = "password hase change sucsessfly";
                } else{
                    $notidication = "password error";
                }
        return $this->render('account/password.html.twig', [
            'form' => $form->createView(),
            'notification' => $notidication
        ]);
    }
}
