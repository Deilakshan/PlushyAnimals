<?php

namespace App\Controller\Admin;

use App\Entity\Contact;
use App\Entity\Produits;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{   
    public function __construct(
        private AdminUrlGenerator $adminUrlGenerator
    ) {
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {   
        $url = $this->adminUrlGenerator
            ->setController(ProduitsCrudController::class)
            // ->setController(UserCrudController::class)
            ->generateUrl();


        return $this->redirect($url);
      
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Plushy Animals');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::subMenu('Produits', 'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Show Produits', 'fas fa-eye', Produits::class)
        ]);

        yield MenuItem::subMenu('Users', 'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Show Users', 'fas fa-eye', User::class)
        ]);

        yield MenuItem::subMenu('Contact Users', 'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Show Contact', 'fas fa-eye', Contact::class)
        ]);
        

    }
}
