<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class OrderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Order::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
     return $crud
         // the labels used to refer to this entity in titles, buttons, etc.
         ->setPaginatorPageSize(15)
         ->setEntityLabelInSingular('Commande')
         ->setEntityLabelInPlural('Commandes');
    }

    public function configureActions(Actions $actions): Actions
    {
      return $actions
            ->add('index', 'detail');
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            DateTimeField::new('createdAt', 'Date de la commande'),
            TextField::new('user.FullName', 'Utilisateur'),
            TextField::new('carrierName', 'Nom du transporteur'),
            MoneyField::new('total', 'Total de la commande')->setCurrency('EUR'),
            TextField::new('delivery', 'Adresse de livraison'),
            BooleanField::new('isPaid', 'Commande Payé'),
        ];
    }
    
}
