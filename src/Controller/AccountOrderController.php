<?php

namespace App\Controller;

use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccountOrderController extends AbstractController
{

   private $entity;

   public function __construct(EntityManagerInterface $entity)
   {
      $this->entity = $entity;
   }
   
    /**
     * @Route("/compte/commande", name="account_order")
     */
    public function index(): Response
    {
         $orders = $this->entity->getRepository(Order::class)->findSuccessOrder($this->getUser());

        return $this->render('account/order.html.twig',[
           'orders' => $orders
        ]);
    }

        /**
     * @Route("/compte/commande/{reference}", name="account_order_detail")
     */
    public function orderDetails($reference): Response
    {
         $order = $this->entity->getRepository(Order::class)->findOneBy(['reference' => $reference]);

         if(!$order || $order->getUser() != $this->getUser()){
            return $this->redirectToRoute('account');
         }

        return $this->render('account/orderDetails.html.twig',[
           'order' => $order
        ]);
    }
}
