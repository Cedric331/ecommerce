<?php

namespace App\Controller;

use Stripe\Stripe;
use App\Entity\Order;
use App\Entity\Product;
use Stripe\Checkout\Session;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StripeController extends AbstractController
{
    /**
     * @Route("/commande/create-checkout-session/{reference}", name="stripe_create")
     */
    public function index(EntityManagerInterface $entity, $reference)
    {
      $productStripe = [];
      $YOUR_DOMAIN = 'http://127.0.0.1:8000';

      $order = $entity->getRepository(Order::class)->findOneBy(['reference' => $reference]);

      if(!$order)
      {
        return new jsonResponse(['error' => 'order']);
      }

      foreach($order->getOrderDetails()->getValues() as $product)
      {
         $product_objet = $entity->getRepository(Product::class)->findOneBy(['name' => $product->getProduct()]);
         $productStripe[] = ['price_data' => [
            'currency' => 'eur',
            'unit_amount' => $product->getPrice(),
            'product_data' => [
              'name' => $product->getProduct(),
              'images' => [$YOUR_DOMAIN . '/uploads/products/'.$product_objet->getIllustration()],
            ],
          ],
          'quantity' => $product->getQuantity(),
       ];
      }

      $productStripe[] = ['price_data' => [
         'currency' => 'eur',
         'unit_amount' => $order->getCarrierPrice(),
         'product_data' => [
           'name' => $order->getCarrierName(),
           'images' => [$YOUR_DOMAIN],
         ],
       ],
       'quantity' => 1,
    ];

      Stripe::setApiKey('sk_test_51IAusCI6YwgpDkGgRmZowmNTpDQPHZRfJFOWrXJU4o3F7tTmeemAL21Ss81Z7PuPmuTchvw0Z8BVDemuYYLlNBOh00WFmn8iGO');


      $checkout_session = Session::create([
         'customer_email' => $this->getUser()->getEmail(),
         'payment_method_types' => ['card'],
         'line_items' => [
             $productStripe
         ],
         'mode' => 'payment',
         'success_url' => $YOUR_DOMAIN . '/commande/merci/{CHECKOUT_SESSION_ID}',
         'cancel_url' => $YOUR_DOMAIN . '/commande/erreur/{CHECKOUT_SESSION_ID}',
     ]);

     $order->setStripeSessionId($checkout_session->id);
     $entity->flush();

     $response = new JsonResponse(['id' => $checkout_session->id]);
     return $response;

    }
}
