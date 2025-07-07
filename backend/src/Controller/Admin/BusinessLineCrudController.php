<?php

namespace App\Controller\Admin;

use App\Entity\BusinessLine;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class BusinessLineCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return BusinessLine::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name', 'Secteur d’activité');
    }
}
