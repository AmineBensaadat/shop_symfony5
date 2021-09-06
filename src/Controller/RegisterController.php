<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    
    private $entityManager;

    //call Doctrine
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;   
    }
    /**
     * @Route("/register", name="register")
     */
    public function index(Request $request, UserPasswordEncoderInterface $encoder)
    {
        // create object from entity User
        $user = new User();

        // create form  depend on entity
        $form = $this->createForm(RegisterType::class, $user);

        // get requests
        $form->handleRequest($request);

        // form validation 
        if($form->isSubmitted() && $form->isValid()) {

            //get data from the from
            $user = $form->getData();

                // hash Password
                $password = $user->getPassword();

                $encoded = $encoder->encodePassword($user, $password);
                $user->setPassword($encoded);

            // passe entity to doctrine
            $this->entityManager->persist($user);

            // set data into table
            $this->entityManager->flush();
        }
        return $this->render('register/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
