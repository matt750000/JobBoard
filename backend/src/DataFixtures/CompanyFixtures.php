<?php

namespace App\DataFixtures;

use App\Entity\BusinessLine;
use App\Entity\Company;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CompanyFixtures extends Fixture implements DependentFixtureInterface
{
    public const COMPANY_RECRUITEUR = 'company_recruteur';

    public function load(ObjectManager $manager): void
    {
        $company = new Company();
        $company->setName('RecruitDev');
        $company->setDescription('Agence tech spécialisée en recrutement IT');
        $company->setCity('Lyon');
        $company->setUser($this->getReference(UserFixtures::USER_RECRUITEUR, User::class));
        $company->setBusinessLine($this->getReference(BusinessLineFixtures::BL_TECH, BusinessLine::class));
        $manager->persist($company);
        $this->addReference(self::COMPANY_RECRUITEUR, $company);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            BusinessLineFixtures::class,
        ];
    }
}
