<?php

namespace App\Controller\Admin;

use App\Entity\Applicant;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ApplicantCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Applicant::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('cvUrl', 'Lien vers le CV');

        $userField = AssociationField::new('user', 'Utilisateur');

        // Optionnel : rendre le champ désactivé sauf en création
        if ($pageName !== Crud::PAGE_NEW) {
            $userField->setFormTypeOption('disabled', true);
        }

        yield $userField;
    }
}
