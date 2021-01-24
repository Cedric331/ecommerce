<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Order;
use App\Form\OrderType;
use App\Entity\OrderDetails;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderController extends AbstractController
{

   private $entity;

   public function __construct(EntityManagerInterface $entity){
      $this->entity = $entity;
   }

    /**
     * @Route("/commande", name="order")
     */
    public function index(Cart $cart): Response
    {
       if($this->getUser()->getAdresses()->getValues() == null){
          return $this->redirectToRoute('adress_add', array('shop' => true));
       }

       $form = $this->createForm(OrderType::class, null, [
          'user' => $this->getUser()
       ]);

        return $this->render('order/index.html.twig',[
            'form' => $form->createView(),
            'cartComplete' => $cart->getFull(),
        ]);
    }

        /**
     * @Route("/commande/recapitulatif", name="order_recap", methods={"POST"})
     */
    public function add(Request $request, Cart $cart): Response
    {

       $form = $this->createForm(OrderType::class, null, [
         'user' => $this->getUser()
      ]);

       $form->handleRequest($request);
       if($form->isSubmitted() && $form->isValid())
       {
          $date = new \DateTime();
          $delivery = $form->get('adresses')->getData();
          $delivery_content = $delivery->getFirstname().' '. $delivery->getLastname();
          $delivery_content .= '<br>'. $delivery->getPhone();
          if($delivery->getCompagny()){
            $delivery_content .= '<br>'. $delivery->getCompagny();
          }
          $delivery_content .= '<br>'. $delivery->getAdress();
          $delivery_content .= '<br>'. $delivery->getCity();
          $delivery_content .= '<br>'. $delivery->getPostal();
          $delivery_content .= '<br>'. $delivery->getCountry();

         $reference = $date->format('dmY').'-'.uniqid();
         $order = new Order();
         $order->setUser($this->getUser())
                ->setCreatedAt($date)
                ->setReference($reference)
                ->setCarrierName($form->get('transporteurs')->getData()->getName())
                ->setCarrierPrice($form->get('transporteurs')->getData()->getPrice())
                ->setDelivery($delivery_content)
                ->setState(0);
         $this->entity->persist($order);

         foreach($cart->getFull() as $product)
         {
            $orderDetail = new OrderDetails();
            $orderDetail->setMyOrder($order)
                        ->setProduct($product['product']->getName())
                        ->setPrice($product['product']->getPrice())
                        ->setQuantity($product['quantity'])
                        ->setTotal($product['product']->getPrice() * $product['quantity']);
            $this->entity->persist($orderDetail);
         }
         
         $this->entity->flush();


         return $this->render('order/add.html.twig',[
            'cartComplete' => $cart->getFull(),
            'carrier' => $order,
            'delivery' => $delivery,
            'reference' => $order->getReference()
        ]);
       }
       return $this->redirectToRoute('cart');
    }
}
