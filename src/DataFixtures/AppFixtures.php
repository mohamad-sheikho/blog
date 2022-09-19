<?php
// les fixtures sont des classe php dans lesquelles on va déclarer plusieurs instances d'objet et que l'on va 
// enregister en base de données. De cette manière, on pourra facilement utiliser ces donées lors du développement
namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
