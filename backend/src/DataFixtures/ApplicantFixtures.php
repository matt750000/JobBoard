<?php

namespace App\DataFixtures;

use App\Entity\Applicant;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ApplicantFixtures extends Fixture implements DependentFixtureInterface
{
    public const APPLICANT_1 = 'applicant_1';

    public function load(ObjectManager $manager): void
    {
        /** @var User $user */
        $user = $this->getReference(UserFixtures::USER_1, User::class);

        // Vérification que le rôle est bien celui d’un candidat
        if (in_array('ROLE_USER', $user->getRoles())) {
            $applicant = new Applicant();
            $applicant->setCvUrl('https://example.com/cv/user1.pdf');
            $applicant->setUser($user);
            $manager->persist($applicant);
            $this->addReference(self::APPLICANT_1, $applicant);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
