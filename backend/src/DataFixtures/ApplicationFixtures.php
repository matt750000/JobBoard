<?php

namespace App\DataFixtures;

use App\Entity\JobOffer;
use App\Entity\Application;
use App\Enum\ApplicationStatus;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ApplicationFixtures extends Fixture implements DependentFixtureInterface
{
    public const APPLICATION_1 = 'application_1';

    public function load(ObjectManager $manager): void
    {
        /** @var \App\Entity\User $user */
        $user = $this->getReference(UserFixtures::USER_1, User::class);

        /** @var \App\Entity\JobOffer $jobOffer */
        $jobOffer = $this->getReference(JobOfferFixtures::JOB_OFFER_RECRUITEUR, JobOffer::class);

        $application = new Application();
        $application->setUser($user);
        $application->setJobOffer($jobOffer);
        // La date et le statut sont déjà initialisés dans le constructeur

        $manager->persist($application);
        $this->addReference(self::APPLICATION_1, $application);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            JobOfferFixtures::class,
        ];
    }
}
