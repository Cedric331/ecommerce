<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class OrderCrudController extends AbstractCrudController
{
   private $entity;
   private $crudUrlGenerator;

   public function __construct(EntityManagerInterface $entity, CrudUrlGenerator $crudUrlGenerator){
      $this->entity = $entity;
      $this->crudUrlGenerator = $crudUrlGenerator;
   }
   
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
         ->setEntityLabelInPlural('Commandes')
         ->setDefaultSort(['id' => 'DESC']);
    }

    public function configureActions(Actions $actions): Actions
    {
      $updatePreparation = Action::new('updatePreparation', 'Préparation en cours','fas fa-truck')
                                    ->linkToCrudAction('updatePreparation');
      $delivry = Action::new('delivry', 'Livraison en cours','fas fa-box')
                                    ->linkToCrudAction('delivry');
      return $actions
            ->add('detail', $updatePreparation)
            ->add('detail', $delivry)
            ->add('index', 'detail');
    }

    public function updatePreparation(AdminContext $context)
    {
      $order = $context->getEntity()->getInstance();
      $order->setState(2);
      $this->entity->flush();

      $url = $this->crudUrlGenerator->build()
                  ->setController(OrderCrudController::class)
                  ->setAction('index')
                  ->generateUrl();
      $this->addFlash('notice', "<span style='color:green;'>Modification effectuée</span>");
      return $this->redirectToRoute('admin');
    }

    public function delivry(AdminContext $context)
    {
      $order = $context->getEntity()->getInstance();
      $order->setState(3);
      $this->entity->flush();

      $url = $this->crudUrlGenerator->build()
                  ->setController(OrderCrudController::class)
                  ->setAction('index')
                  ->generateUrl();
      $this->addFlash('notice', "<span style='color:green;'>Modification effectuée</span>");
      return $this->redirectToRoute('admin');
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            DateTimeField::new('createdAt', 'Date de la commande'),
            // TextField::new('user.FullName', 'Utilisateur'),
            TextField::new('carrierName', 'Nom du transporteur'),
            MoneyField::new('carrierPrice', 'Prix du transporteur')->setCurrency('EUR'),
            MoneyField::new('total', 'Total de la commande')->setCurrency('EUR'),
            TextField::new('delivery', 'Adresse de livraison')->onlyOnDetail(),
            ChoiceField::new('state', 'Statut')->setChoices([
               'Non payé' => 0,
               'Payé' => 1,
               'Préparation en cours' => 2,
               'Livraison en cours' => 3,
            ]),
        ];
    }
}
