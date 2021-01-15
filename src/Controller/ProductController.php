<?php

namespace App\Controller;

use App\Classe\Search;
use App\Form\SearchType;
use App\entity\Productentity;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
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
    public function index(Request $request): Response
    {

       $search = new Search();
       $form = $this->createForm(SearchType::class, $search);

       $form->handleRequest($request);

       if($form->isSubmitted() && $form->isValid())
       {
          $products = $this->repository->findWithSearch($search);
       }
       else{
         $products = $this->repository->findAll();
       }

        return $this->render('product/index.html.twig',[
           'products' => $products,
           'form' => $form->createView()
        ]);
    }

      /**
     * @Route("/produits/{slug}", name="products_show")
     */
    public function show($slug): Response
    {
       $product = $this->repository->findOneBySlug($slug);

       if(!$product)
       {
          return $this->redirectToRoute('products');
       }

        return $this->render('product/show.html.twig',[
           'product' => $product,
        ]);
    }
}
