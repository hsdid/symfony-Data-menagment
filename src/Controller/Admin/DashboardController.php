<?php

namespace App\Controller\Admin;

use App\Entity\LikeProduct;
use App\Entity\Product;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        $routeBuilder = $this->get(AdminUrlGenerator::class);

        return $this->redirect($routeBuilder->setController(ProductCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Data Menagment');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::section('Important');
        yield MenuItem::linkToCrud('Products', 'fa fa-product',Product::class);
        yield MenuItem::linkToCrud('LikeProducts', 'fa fa-like',LikeProduct::class);
        yield MenuItem::linkToCrud('User', 'fa fa-user',User::class);
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}
