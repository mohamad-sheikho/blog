<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategroyFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // la je viens de créer mes deux category
        $sport = new Category();
        $sport->setName('Sport');

    


        $manager->persist($sport);

        $maison = new Category();
        $maison->setName('Maison');

       


        $manager->persist($maison);

        $manager->flush();
    }
    // il va falloir qu'on rattache ces catégories a nos articles
    public function getDependencies(){
        return[
            //on va avoir besoin des dependances qui concernes les articles 
            ArticleFixtures::class
        ];
    }

}
