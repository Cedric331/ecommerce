<?php

namespace App\Controller;

use App\Classe\Cart;
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
     * @Route("/commande/merci/{stripeSessionId}", name="order_success")
     */
    public function success($stripeSessionId, Cart $cart): Response
    {
      
       $order = $this->entity->getRepository(Order::class)->findOneBy(['stripeSessionId' => $stripeSessionId]);

       if(!$order || $order->getUser() != $this->getUser()){
          return $this->redirectToRoute('home');
       }

       if($order->getState() == 0)
       {
         $cart->removeAll();
         $order->setState(1);
         $this->entity->flush();

         // envoi de mail
       }
        return $this->render('order_validate/success.html.twig',[
           'order' => $order
        ]);
    }

        /**
     * @Route("/commande/erreur/{stripeSessionId}", name="order_cancel")
     */
    public function cancel($stripeSessionId): Response
    {
      
       $order = $this->entity->getRepository(Order::class)->findOneBy(['stripeSessionId' => $stripeSessionId]);

       if(!$order || $order->getUser() != $this->getUser()){
          return $this->redirectToRoute('home');
       }

        return $this->render('order_validate/cancel.html.twig',[
           'order' => $order
        ]);
    }
}
