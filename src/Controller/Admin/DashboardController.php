<?php

namespace App\Controller\Admin;

use App\Entity\Client;
use App\Entity\Produit;
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
        // $routeBuilder = $this->get(AdminUrlGenerator::class);

        // return $this->redirect($routeBuilder->setController(ProduitCrudController::class)->generateUrl());

         return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('ProjetFilRouge');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::section('Utilisateurs');
        yield MenuItem::linktoDashboard('Dashboard','fa fa-home');
        yield MenuItem::linkToCrud('Client','fa fa-user', Client::class);
        yield MenuItem::linkToCrud('Produits','fa fa-list', Produit::class);     
    }

}