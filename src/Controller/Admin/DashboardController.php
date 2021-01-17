<?php

namespace App\Controller\Admin;

use App\Entity\Carrier;
use App\Entity\User;
use App\Entity\Product;
use App\Entity\Category;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Boutique Star Wars');
    }

    public function configureMenuItems(): iterable
    {
      yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
      yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-user', User::class);
      yield MenuItem::linkToCrud('Catégories', 'fas fa-list', Category::class);
      yield MenuItem::linkToCrud('Produits', 'fas fa-tags', Product::class);
      yield MenuItem::linkToCrud('Transporteurs', 'fas fa-truck', Carrier::class);
    }
}
