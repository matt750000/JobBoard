<?php

namespace App\Controller\Admin;

use App\Entity\Company;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CompanyCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Company::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name', 'Nom de l’entreprise');
        yield TextareaField::new('description', 'Description');
        yield TextField::new('city', 'Ville');

        $userField = AssociationField::new('user', 'Propriétaire');
        $sectorField = AssociationField::new('businessLine', 'Secteur');

        // 🔒 Désactivation des champs après création
        if ($pageName !== Crud::PAGE_NEW) {
            $userField->setFormTypeOption('disabled', true);
            $sectorField->setFormTypeOption('disabled', true);
        }

        yield $userField;
        yield $sectorField;
    }
}
