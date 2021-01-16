<?php

namespace App\Form;

use App\Entity\Adress;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;

class AdressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
               'label' => 'Nom de l\'adresse :',
               'attr' => [
                  'placeholder' => 'Veuillez entrer le nom de cette adresse'
               ]
            ])
            ->add('firstname', TextType::class, [
               'label' => 'Votre prénom :',
               'attr' => [
                  'placeholder' => 'Veuillez le prénom du destinataire'
               ]
            ])
            ->add('lastname', TextType::class, [
               'label' => 'Votre nom :',
               'attr' => [
                  'placeholder' => 'Veuillez le nom du destinataire'
               ]
            ])
            ->add('compagny', TextType::class, [
               'label' => 'Nom de l\'entreprise :',
               'required' => false,
               'attr' => [
                  'placeholder' => '(facultatif) Veuillez indiquer le nom de l\'entreprise'
               ]
            ])
            ->add('adress', TextType::class, [
               'label' => 'Votre adresse :',
               'attr' => [
                  'placeholder' => 'Veuillez indiquer l\'adresse de livraison'
               ]
            ])
            ->add('postal', TextType::class, [
               'label' => 'Votre code postal :',
               'attr' => [
                  'placeholder' => 'Veuillez indiquer le code postal'
               ]
            ])
            ->add('city', TextType::class, [
               'label' => 'Votre ville :',
               'attr' => [
                  'placeholder' => 'Veuillez le nom de la ville'
               ]
            ])
            ->add('country', CountryType::class, [
               'label' => 'Votre pays :',
               'attr' => [
                  'placeholder' => 'Veuillez indiquer le pays'
               ]
            ])
            ->add('phone', TelType::class, [
               'label' => 'Votre numéro de téléphone :',
               'attr' => [
                  'placeholder' => 'Veuillez indiquer le numéro de téléphone'
               ],
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Adress::class,
        ]);
    }
}
