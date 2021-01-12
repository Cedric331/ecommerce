<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RegisterController extends AbstractController
{
    /**
     * @Route("/inscription", name="register")
     */
    public function register(): Response
    {
      $user = new User();

      $form = $this->createForm(RegisterType::class, $user);



        return $this->render('register/register.html.twig',[
           'form' => $form->createView()
        ]);
    }
}
