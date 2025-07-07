<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public const USER_1 = 'user_1';
    public const USER_2 = 'USER_2';
    public const USER_RECRUITEUR = 'user_recruteur';

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('admin@admin.com');
        $user->setFirstName('John');
        $user->setLastName('Doe');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPlainPassword('demo');
        $manager->persist($user);

        $recruiter = new User();
        $recruiter->setEmail('recruteur@example.com');
        $recruiter->setRoles(['ROLE_RECRUTEUR']);
        $recruiter->setFirstName('Habib');
        $recruiter->setLastName('Mathieu');
        $recruiter->setPlainPassword('demo');
        $manager->persist($recruiter);
        $this->addReference(self::USER_RECRUITEUR, $recruiter);

        $user = new User();
        $user->setEmail('user1@user.com');
        $user->setFirstName('John1');
        $user->setLastName('cihl');
        $user->setPlainPassword('demo');
        $this->addReference(self::USER_1, $user);
        $manager->persist($user);

        $user = new User();
        $user->setEmail('user2@user.com');
        $user->setFirstName('John2');
        $user->setLastName('habib');
        $user->setPlainPassword('demo');
        $this->addReference(self::USER_2, $user);
        $manager->persist($user);

        $manager->flush();
    }
}
