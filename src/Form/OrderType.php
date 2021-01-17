<?php

namespace App\Form;


use App\Entity\Adress;
use App\Entity\Carrier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $user = $options['user'];
        $builder
            ->add('adresses', EntityType::class, [
               'label' => "Choisir votre adresse :",
               'required' => true,
               'class' => Adress::class,
               'choices' => $user->getAdresses(),
               'multiple' => false,
               'expanded' => true, 
               'attr' => [
                  'class' => 'col-12 mt-2'
               ]
            ])
            ->add('transporteurs', EntityType::class, [
               'label' => "Choisir votre transporteur :",
               'required' => true,
               'class' => Carrier::class,
               'multiple' => false,
               'expanded' => true, 
               'attr' => [
                  'class' => 'col-12 mt-2'
               ]
            ])
            ->add('submit', SubmitType::class, [
               'label' => "Valider ma commande", 
               'attr' => [
                  'class' => 'btn-success btn-block btn-lg mt-3'
               ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'user' => array()
        ]);
    }
}
