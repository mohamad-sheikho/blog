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

        $tout = new Category();
        $tout->setName('Tout');

        $manager->persist($tout);


        $dev = new Category();
        $dev->setName('Dev');

        $manager->persist($dev);

        $femme = new Category();
        $femme->setName('Femme');

        $manager->persist($femme);

        $gossip = new Category();
        $gossip->setName('Gossip La Plateforme');

        $manager->persist($gossip);

        $bl = new Category();
        $bl->setName('BALANCE TOUT');

        $manager->persist($bl);




        // $plateforme = new Category();
        // $plateforme->setName('LaPlateforme');

       


        // $manager->persist($plateforme);

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
