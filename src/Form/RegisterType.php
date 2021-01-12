<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
               'label' => 'Votre prénom :',
               'attr' => ['placeholder' => 'Prénom']
            ])
            ->add('lastname', TextType::class, [
               'label' => 'Votre nom :',
               'attr' => ['placeholder' => 'Nom']
            ])
            ->add('email', EmailType::class, [
               'label' => 'Votre adresse email :',
               'attr' => ['placeholder' => 'Email']
            ])
            ->add('password', PasswordType::class, [
               'label' => 'Votre mot de passe :',
               'attr' => ['placeholder' => 'Mot de passe']
            ])
            ->add('password_confirmation', PasswordType::class, [
               'label' => 'Confirmer votre mot de passe :',
               'mapped' => false,
               'attr' => ['placeholder' => 'Confirmer le mot de passe']
            ])
            ->add('submit', SubmitType::class, [
               'label' => "S'inscrire", 
               'attr' => [
                  'class' => 'btn btn-outline-primary btn-lg mt-3'
               ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
