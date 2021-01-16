<?php 

namespace App\Classe;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Cart
{

   private $session;
   private $entity;

   public function __construct(EntityManagerInterface $entity, SessionInterface $session)
   {
      $this->session = $session;
      $this->entity = $entity;
   }

   /**
    * Ajoute un produit dans le panier
    *
    * @param [type] $id
    * @return void
    */
   public function add($id)
   {
      $cart = $this->session->get('cart', []);

      if(!empty($cart[$id]))
      {
         $cart[$id]++;
      }
      else{
         $cart[$id] = 1;
      }

      $this->session->set('cart', $cart);
   }

   /**
    * Supprime un produit dans le panier
    *
    * @param [type] $id
    * @return void
    */
   public function remove($id)
   {
      $cart = $this->session->get('cart', []);

      if(!empty($cart[$id]))
      {
         $cart[$id]--;
      }

      if($cart[$id] == 0){
         unset($cart[$id]);
      }

     return $this->session->set('cart', $cart);
   }

   public function delete($id)
   {
      $cart = $this->session->get('cart', []);

         unset($cart[$id]);

      return  $this->session->set('cart', $cart);
   }

   public function removeAll()
   {
      return $this->session->remove('cart');
   }

   public function get()
   {
      return $this->session->get('cart');
   }

   public function getFull()
   {
      $cartComplete = [];

      if ($this->get() != null ) {
         foreach ($this->get() as $id => $quantity) {
            $product_object = $this->entity->getRepository(Product::class)->find($id);

            if(!$product_object){
               $this->delete($id);
               continue;
            }
            $cartComplete[] = [
               'product' => $product_object,
               'quantity' => $quantity
            ];
         }
      }

      return $cartComplete;
   }

}