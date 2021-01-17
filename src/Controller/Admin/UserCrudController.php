<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
     return $crud
         // the labels used to refer to this entity in titles, buttons, etc.
         ->setEntityLabelInSingular('Utilisateur')
         ->setEntityLabelInPlural('Utilisateurs');
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            EmailField::new('email', 'Email'),
            TextField::new('password', 'Mot de passe'),
            TextField::new('firstname', 'Prénom'),
            TextField::new('lastname', 'Nom'),
        ];
    }
    
}
