<?php

namespace App\Controller;

use App\Entity\Adress;
use App\Form\AdressType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdressController extends AbstractController
{

   private $entity;

   public function __construct(EntityManagerInterface $entity)
   {
      $this->entity = $entity;
   }
   
    /**
     * @Route("/compte/adresse", name="adress")
     */
    public function index(): Response
    {
       $adresses = $this->getUser()->getAdresses();

        return $this->render('account/adress.html.twig', [
           'adresses' => $adresses
        ]);
    }

   /**
     * @Route("/compte/adresse/creation/{shop}", name="adress_add")
     */
    public function add(Request $request, $shop = null): Response
    {
      $adress = new Adress();
      $form = $this->createForm(AdressType::class, $adress);
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
         $adress = $adress->setUser($this->getUser());
         $this->entity->persist($adress);
         $this->entity->flush();

         if($shop == true){
            return $this->redirectToRoute('order');
         }
         $this->addFlash('success','Adresse ajoutée');
         return $this->redirectToRoute('adress');
      }

      return $this->render('account/adress_form.html.twig', [
         'form' => $form->createView(),
         'update' => false
      ]);
    }

       /**
     * @Route("/compte/adresse/{id}", name="adress_update")
     */
    public function update(Request $request, $id): Response
    {
      $adress = $this->entity->getRepository(Adress::class)->find($id);
      if(!$adress || $adress->getUser() != $this->getUser())
      {
         return $this->redirectToRoute('adress');
      }

      $form = $this->createForm(AdressType::class, $adress);
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
         $adress = $adress->setUser($this->getUser());
         $this->entity->flush();
         $this->addFlash('success','Adresse modifiée');

         return $this->redirectToRoute('adress');
      }

      return $this->render('account/adress_form.html.twig', [
         'form' => $form->createView(),
         'update' => true
      ]);
    }

           /**
     * @Route("/compte/adresse/delete/{id}", name="adress_delete")
     */
    public function delete($id)
    {
       $adress = $this->entity->getRepository(Adress::class)->find($id);

       if(!$adress && $adress->getUser() != $this->getUser())
         {
          return $this->redirectToRoute('adress');
         }

         $this->entity->remove($adress);
         $this->entity->flush();

         $this->addFlash('success','Adresse supprimée');

         return $this->redirectToRoute('adress');
    }
}
