<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterController extends AbstractController
{

   private $entity;

   public function __construct( EntityManagerInterface $entity){
      $this->entity = $entity;
   }

    /**
     * @Route("/inscription", name="register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
      $user = new User();

      $form = $this->createForm(RegisterType::class, $user);
      $form->handleRequest($request);

      if($form->isSubmitted() && $form->isValid())
      {
         $user->setPassword($encoder->encodePassword($user, $user->getPassword()));
         $this->entity->persist($user);
         $this->entity->flush();
      }

        return $this->render('register/register.html.twig',[
           'form' => $form->createView()
        ]);
    }
}
