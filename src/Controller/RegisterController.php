<?php

namespace App\Controller;

use App\Classes\Mail;
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

        $notification = null;
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

            // check if user aradey exist in the database
                $search_email = $this->entityManager->getRepository(User::class)->findOneByEmail($user->getEmail());

                if(!$search_email){
                    // hash Password
                    $password = $user->getPassword();

                    $encoded = $encoder->encodePassword($user, $password);
                    $user->setPassword($encoded);

                    // passe entity to doctrine
                    $this->entityManager->persist($user);

                    // set data into table
                    $this->entityManager->flush();

                    // send email to customer
                    $mail = new Mail();
                    $content = "merci pour votre inscription";
                    $mail->send($user->getEmail(), $user->getFullName(), 'inscription', $user->getFullName(), $content);
                 
                    $notification = " Votre inscription c'est correctement dérouler ";
                } else {
                    $notification = " l'email aradeay exist ";
                }
        }
        return $this->render('register/index.html.twig', [
            'form' => $form->createView(),
            'notification' => $notification
        ]);
    }
}
