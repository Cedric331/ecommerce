<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureCrud(Crud $crud): Crud
   {
    return $crud
        // the labels used to refer to this entity in titles, buttons, etc.
        ->setPaginatorPageSize(15)
        ->setEntityLabelInSingular('Produit')
        ->setEntityLabelInPlural('Produits');
   }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('name', 'Nom'),
            SlugField::new('slug', 'Url')->setTargetFieldName('name'),
            TextField::new('subtitle', 'Sous-titre'),
            ImageField::new('illustration', 'Image')
                     ->setBasePath('uploads/products')
                     ->setUploadDir('public/uploads/products')
                     ->setUploadedFileNamePattern('[randomhash].[extension]'),
            TextEditorField::new('description'),
            BooleanField::new('isBest', 'Best'),
            MoneyField::new('price', 'Prix')->setCurrency('EUR'),
            AssociationField::new('category', 'Catégorie')->setRequired(true)
        ];
    }

}
