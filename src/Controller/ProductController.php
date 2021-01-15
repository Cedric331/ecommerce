<?php

namespace App\Controller;

use App\entity\Productentity;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{

   private $entity;
   private $repository;

   public function __construct(EntityManagerInterface $entity, ProductRepository $repository)
   {
      $this->entity = $entity;
      $this->repository = $repository;
   }
    /**
     * @Route("/produits", name="products")
     */
    public function index(): Response
    {
       $products = $this->repository->findAll();

        return $this->render('product/index.html.twig',[
           'products' => $products,
        ]);
    }
}
