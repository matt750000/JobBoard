<?php

namespace App\Controller\Admin;

use App\Entity\Applicant;
use App\Entity\Application;
use App\Entity\BusinessLine;
use App\Entity\Company;
use App\Entity\JobOffer;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Job Board');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Tableau de bord', 'fa fa-home');
        yield MenuItem::linkToCrud('Offres d’emploi', 'fas fa-list', JobOffer::class);
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-users', User::class);
        yield MenuItem::linkToCrud('Candidats', 'fas fa-user-tie', Applicant::class);
        yield MenuItem::linkToCrud('Candidatures', 'fas fa-file-alt', Application::class);
        yield MenuItem::linkToCrud('Secteurs d’activité', 'fas fa-sitemap', BusinessLine::class);
        yield MenuItem::linkToCrud('Entreprises', 'fas fa-building', Company::class);
    }
}
