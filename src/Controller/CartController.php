<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{

    /**
     * @Route("/compte/panier", name="cart")
     */
    public function index(Cart $cart): Response
    {
        return $this->render('cart/cart.html.twig', [
           'cartComplete' => $cart->getFull(),
           ]);
    }

      /**
     * @Route("/compte/panier/add/{id}", name="cart_add")
     */
    public function add(Cart $cart, $id): Response
    {
        $cart->add($id);

        return $this->redirectToRoute('cart');
    }

      /**
     * @Route("/compte/panier/remove", name="cart_remove_all")
     */
    public function removeAll(Cart $cart): Response
    {
        $cart->removeAll();

        return $this->redirectToRoute('cart');
    }

   /**
     * @Route("/compte/panier/remove/{id}", name="cart_remove")
     */
    public function removeOne(Cart $cart, $id): Response
    {
        $cart->remove($id);

        return $this->redirectToRoute('cart');
    }

   /**
     * @Route("/compte/panier/delete/{id}", name="cart_delete")
     */
    public function delete(Cart $cart, $id): Response
    {
        $cart->delete($id);

        return $this->redirectToRoute('cart');
    }

}
