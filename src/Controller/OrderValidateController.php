<?php

namespace App\Controller;

use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderValidateController extends AbstractController
{
   private $entity;

   public function __construct(EntityManagerInterface $entity){
      $this->entity = $entity;
   }
   
    /**
     * @Route("/commande/merci/{stripeSessionId}", name="order_validate")
     */
    public function index($stripeSessionId): Response
    {
      
       $order = $this->entity->getRepository(Order::class)->findOneBy(['stripeSessionId' => $stripeSessionId]);

       if(!$order || $order->getUser() != $this->getUser()){
          return $this->redirectToRoute('home');
       }

       if($order->getIsPaid() == false)
       {
         $order->setIsPaid(true);
         $this->entity->flush();

         // envoi de mail
       }
        return $this->render('order_validate/success.html.twig',[
           'order' => $order
        ]);
    }
}
