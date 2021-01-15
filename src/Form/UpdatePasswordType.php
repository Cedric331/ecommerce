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

class UpdatePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
               'disabled' => true,
               'label' => "Mon adresse email"
            ])
            ->add('firstname', TextType::class, [
               'disabled' => true,
               'label' => "Mon prénom"
            ])
            ->add('lastname', TextType::class, [
               'disabled' => true,
               'label' => "Mon nom"
            ])
            ->add('old_password', PasswordType::class,[
               'label' => "Mon mot de passe",
               'mapped' => false,
               'attr' => [
                  'placeholder' => "Veuillez saisir votre mot de passe actuel"
               ]
            ])
            ->add('new_password', RepeatedType::class, [
               'type' => PasswordType::class,
               'mapped' => false,
               'invalid_message' => "Les mots de passe doivent être identiques",
               'required' => true,
               'first_options' => 
               ['label' => 'Nouveau votre mot de passe :',
                  'attr' => 
                     ['placeholder' => 'Nouveau Mot de passe']
               ],
               'second_options' => 
               ['label' => 'Confirmer votre nouveau mot de passe :',
                  'attr' => 
                        ['placeholder' => 'Confirmer le nouveau mot de passe']
               ],
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
