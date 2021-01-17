<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Form\OrderType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderController extends AbstractController
{
    /**
     * @Route("/commande", name="order")
     */
    public function index(Request $request, Cart $cart): Response
    {
       if($this->getUser()->getAdresses()->getValues() == null){
          return $this->redirectToRoute('adress_add', array('shop' => true));
       }

       $form = $this->createForm(OrderType::class, null, [
          'user' => $this->getUser()
       ]);

       $form->handleRequest($request);
       if($form->isSubmitted() && $form->isValid())
       { 
       }

 
        return $this->render('order/index.html.twig',[
            'form' => $form->createView(),
            'cartComplete' => $cart->getFull(),
        ]);
    }
}
