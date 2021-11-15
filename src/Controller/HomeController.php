<?php

namespace App\Controller;

use App\Classes\Mail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {

        $mail = new Mail();
        return $this->render('home/index.html.twig');
    }
}
