<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{

   private $entity;

   public function __construct(EntityManagerInterface $entity)
   {
      $this->entity = $entity;
   }

    /**
     * @Route("/", name="home")g
     */
    public function index(): Response
    {
      // $mail = new Mail();
      // $mail->send("limacedric@hotmail.fr","Jean","test");

      $products = $this->entity->getRepository(Product::class)->findByIsBest(true);

        return $this->render('home/home.html.twig', [
           'products' => $products
        ]);
    }
}
