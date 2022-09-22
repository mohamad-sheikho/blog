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
        $user->setPassword('$2y$13$tu8QCReCZ3Nmo9k4sglHBOUmDH10GvpXb2d3cdmNKW5MbsaCINBhu');
        $manager->persist($user);
        
        $admin = new User();
        $admin->setUsername('admin');
        $admin->setPassword('$2y$13$DtzGqQ2M/ry4ANmFKZDiuuX93/yRKBiz2Y3n8TXJe556ozY1mu0dm');
        $admin->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);
        $manager->flush();
    }
}
