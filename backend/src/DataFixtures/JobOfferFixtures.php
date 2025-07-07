<?php

namespace App\DataFixtures;

use App\Entity\Company;
use App\Entity\JobOffer;
use App\Enum\TypeContrat;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class JobOfferFixtures extends Fixture implements DependentFixtureInterface
{
    public const JOB_OFFER_RECRUITEUR = 'job_offer_recruteur';

    public function load(ObjectManager $manager): void
    {
        $offer = new JobOffer();
        $offer->setTitle('Dev Backend Symfony');
        $offer->setDescription('Rejoignez un projet API ambitieux chez RecruitDev.');
        $offer->setTypeContrat(TypeContrat::CDI);
        $offer->setSalary(50000);
        $offer->setLocation('Lyon');
        $offer->setPublishedAt(new \DateTimeImmutable());
        $offer->setCompany($this->getReference(CompanyFixtures::COMPANY_RECRUITEUR, Company::class));
        $manager->persist($offer);
        $this->addReference(self::JOB_OFFER_RECRUITEUR, $offer);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CompanyFixtures::class,
        ];
    }
}
