<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setUsername('paul');
        $user->setPassword('$2y$13$DrLb1P.YRDgTe4SyiPoR4upYvENZclU9i4YzcyJA4DkheNfmKWPsu');
        // $user->setRoles(['ROLE_USER']);
        $manager->persist($user);
        
        $admin = new User();
        $admin->setUsername('admin');
        $admin->setPassword('$2y$13$iaclZzFcWQeehLXphjlyoe2scDrPaBrFpfhcOWvOYZiek4XMdBeHS');
        $admin->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);
        $manager->flush();
    }
}
