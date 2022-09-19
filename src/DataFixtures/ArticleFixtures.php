<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        for($i = 1; $i < 10; $i++){

            $article = new Article();
            // la est l'erreur de n° (.) le putin de point !!!!!!!!!!!!!!
            $article->setTitre("Article N°.$i");
            $article->setContenu("Ceci est le contenu de l'article");

            
// cette fonction modify nous permet de modifier notre date quon a actuellement 
            $date = new \DateTime();
            $date->modify('-'.$i.'days');
            $article->setDateCreation($date);

            $this->addReference('article-'.$i, $article);
    
            $manager->persist($article);
        }

        $manager->flush();
    }
}
