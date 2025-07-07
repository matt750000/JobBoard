<?php

namespace App\Controller\Admin;

use App\Entity\JobOffer;
use App\Enum\TypeContrat;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class JobOfferCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return JobOffer::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('title', 'Intitulé du poste');
        yield TextareaField::new('description', 'Description');
        ChoiceField::new('typeContrat', 'Type de contrat')
            ->setChoices(
                array_combine(
                    array_map(fn($e) => $e->name, TypeContrat::cases()),
                    array_map(fn($e) => $e, TypeContrat::cases())
                )
            )
            ->renderExpanded()
            ->allowMultipleChoices(false);
        yield IntegerField::new('salary', 'Salaire')
            ->setFormTypeOption('attr', ['min' => 0]);
        yield TextField::new('location', 'Localisation');
        yield DateTimeField::new('publishedAt', 'Date de publication');
        yield AssociationField::new('company', 'Entreprise');
    }
}
