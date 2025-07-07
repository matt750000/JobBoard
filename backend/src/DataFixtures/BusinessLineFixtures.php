<?php

namespace App\DataFixtures;

use App\Entity\BusinessLine;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BusinessLineFixtures extends Fixture
{
    public const BL_TECH = 'business_line_tech';
    public const BL_MARKETING = 'business_line_marketing';

    public function load(ObjectManager $manager): void
    {
        $tech = new BusinessLine();
        $tech->setName('Technologie');
        $manager->persist($tech);
        $this->addReference(self::BL_TECH, $tech);

        $marketing = new BusinessLine();
        $marketing->setName('Marketing & Communication');
        $manager->persist($marketing);
        $this->addReference(self::BL_MARKETING, $marketing);

        $manager->flush();
    }
}
