<?php

namespace App\Controller\Admin;

use App\Entity\Categories;
use App\Entity\Establishments;
use App\Entity\Images;
use App\Entity\Users;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    public function __construct(
        private AdminUrlGenerator $adminUrlGenerator
    )
    {
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(UsersCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('InkLink');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::subMenu('Utilisateurs', 'fa fa-gear')->setSubItems([
            MenuItem::linkToCrud('Utilisateurs', 'fas fa-user', Users::class),
            MenuItem::linkToCrud('Établissements', 'fas fa-building', Establishments::class)]);
        yield MenuItem::subMenu('Contenu', 'fa fa-gear')->setSubItems([
            MenuItem::linkToCrud('Images', 'fas fa-image', Images::class),
            MenuItem::linkToCrud('Catégories', 'fas fa-newspaper', Categories::class)]);
    }
}
