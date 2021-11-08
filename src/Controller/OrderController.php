<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\OrderType;
use App\Classes\Cart;
use App\Entity\Order;
use App\Entity\OrderProducts;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class OrderController extends AbstractController
{
    private $entityManager;

    //call Doctrine
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;   
    }
    
    /**
     * @Route("/order", name="order")
     */
    public function index(Cart $cart, Request $request): Response
    {
        if(!$this->getUser()->getAddresses()->getValues()){
            return $this->redirectToRoute('account_address_add');
        }
        $form = $this->createForm(OrderType::class, null, [
            'user' =>$this->getUser()
        ]);

        return $this->render('order/index.html.twig',[
            'form' => $form->createView(),
            'cart' => $cart->getFull()
        ]);
    }

    /**
     * @Route("/order/recap", name="order_recap", methods={"POST"})
     */
    public function add(Cart $cart, Request $request): Response
    {
 
        $form = $this->createForm(OrderType::class, null, [
            'user' =>$this->getUser()
        ]);
        // get requests
        $form->handleRequest($request);
        // form validation  
        if($form->isSubmitted() && $form->isValid()) {
            // save my order Orders
                $date = new \DateTime();
                $carriers = $form->get('carriers')->getData();
                $delevry = $form->get('addresses')->getData();
                $delevry_content = $delevry->getFirstname(). ' ' .$delevry->getLastname();
                $delevry_content .= '<br/>'.$delevry->getPhone();
                if($delevry->getCompany()){
                    $delevry_content .= '<br/>'.$delevry->getCompany();
                }

                $delevry_content .= '<br/>'.$delevry->getAddress();
                $delevry_content .= '<br/>'.$delevry->getPostal(). ' ' .$delevry->getCity();
                $delevry_content .= '<br/>'.$delevry->getCountry();
            
                $order = new Order();
                $order->setUser($this->getUser());
                $order->setCreatedAt($date);
                $order->setCarrierName($carriers->getName());
                $order->setCarrierPrice($carriers->getPrice());
                $order->setDelivery($delevry_content);
                $order->setIsPaid(0);
                // passe entity to doctrine
                $this->entityManager->persist($order);
            // save my Products
                foreach ($cart->getFull() as $product) {
                    
                    $orderProducts = new OrderProducts();
                    $orderProducts->setProductOrder($order);
                    $orderProducts->setProduct($product["product"]->getName());
                    $orderProducts->setQuantity($product["quantity"]);
                    $orderProducts->setPrice($product["product"]->getPrice());
                    $orderProducts->setTotal($product["product"]->getPrice() * $product["quantity"]);
                    // passe entity to doctrine
                    $this->entityManager->persist($orderProducts);
                }

                // set data into table
                $this->entityManager->flush();

                return $this->render('order/add.html.twig',[
                    'cart' => $cart->getFull(),
                    'carrier' => $carriers,
                    'delivery' => $delevry_content
                ]);
        }

        return $this->redirectToRoute('cart');
       
    }
}
