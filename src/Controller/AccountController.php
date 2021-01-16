<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserUpdateType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccountController extends AbstractController
{

   private $entity;

   public function __construct(EntityManagerInterface $entity)
   {
      $this->entity = $entity;
   }

    /**
     * @Route("/compte", name="account")
     */
    public function index(): Response
    {
        return $this->render('account/account.html.twig');
    }

    /**
     * @Route("/compte/information", name="account_information")
     *
     * @param Request $request
     */
    public function information(Request $request)
    {
       $user = $this->getUser();
       $notification = null;
       $form = $this->createForm(UserUpdateType::class, $user);

       $form->handleRequest($request);

       if ($form->isSubmitted() && $form->isValid()) {
         $this->entity->persist($user);
         $this->entity->flush();

         $notification = "Modification effectuée";
       }

       return $this->render('account/information.html.twig', [
          'form' => $form->createView(),
          'notification' => $notification
       ]);
    }
}
