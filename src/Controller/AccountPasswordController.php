<?php

namespace App\Controller;

use App\Form\UpdatePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountPasswordController extends AbstractController
{

   private $entity;

   public function __construct(EntityManagerInterface $entity)
   {
      $this->entity = $entity;
   }

    /**
     * @Route("/compte/password", name="account_password")
     */
    public function index(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
       $notification = null;
       $user = $this->getUser();

       $form = $this->createForm(UpdatePasswordType::class, $user);

       $form->handleRequest($request);

       if($form->isSubmitted() && $form->isValid())
       {
          $old_password = $form->get("old_password")->getData();

            if($encoder->isPasswordValid($user, $old_password))
            {
               $new_password = $form->get("new_password")->getData();
               $user->setPassword($encoder->encodePassword($user, $new_password));

               $this->entity->flush();

               $notification = "Votre mot de passe est à jour";
            }
            else {
               $notification = "Votre mot de passe actuel n'est pas correct";
            }
       }

        return $this->render('account/password.html.twig',[
           'form' => $form->createView(),
           'notification' => $notification
        ]);
    }
}
