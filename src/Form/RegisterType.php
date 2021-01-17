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
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
               'required' => true,
               'label' => 'Votre prénom :',
               'attr' => ['placeholder' => 'Prénom']
            ])
            ->add('lastname', TextType::class, [
               'required' => true,
               'label' => 'Votre nom :',
               'attr' => ['placeholder' => 'Nom']
            ])
            ->add('email', EmailType::class, [
               'required' => true,
               'label' => 'Votre adresse email :',
               'attr' => ['placeholder' => 'Email']
            ])
            ->add('password', RepeatedType::class, [
               'type' => PasswordType::class,
               'invalid_message' => "Les mots de passe doivent être identiques",
               'required' => true,
               'first_options' => 
               ['label' => 'Votre mot de passe :',
                  'attr' => 
                     ['placeholder' => 'Mot de passe']
               ],
               'second_options' => 
               ['label' => 'Votre mot de passe :',
                  'attr' => 
                        ['placeholder' => 'Confirmer le mot de passe']
               ],
            ])
            ->add('submit', SubmitType::class, [
               'label' => "S'inscrire", 
               'attr' => [
                  'class' => 'btn-outline-primary btn-lg mt-3'
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
