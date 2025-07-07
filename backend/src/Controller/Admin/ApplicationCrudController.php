<?php

namespace App\Controller\Admin;

use App\Entity\Application;
use App\Enum\ApplicationStatus;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;

class ApplicationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Application::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield DateTimeField::new('appliedAt', 'Date de candidature');

        yield ChoiceField::new('status', 'Statut')
            ->setFormTypeOption('choices', ApplicationStatus::cases())
            ->setFormTypeOption('choice_label', fn(ApplicationStatus $status) => $status->value)
            ->setFormTypeOption('choice_value', fn(ApplicationStatus $status) => $status->name)
            ->renderAsBadges([
                'EN_ATTENTE' => 'warning',
                'ACCEPTEE' => 'success',
                'REFUSEE' => 'danger',
            ]);

        $userField = AssociationField::new('user', 'Candidat');
        $offerField = AssociationField::new('jobOffer', 'Offre d’emploi');

        // 🔒 Empêche l'édition du candidat et de l'offre après création
        if ($pageName !== Crud::PAGE_NEW) {
            $userField->setFormTypeOption('disabled', true);
            $offerField->setFormTypeOption('disabled', true);
        }

        yield $userField;
        yield $offerField;
    }
}
