<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Comment;

class CommentFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {


        for($i = 1; $i <= 10; $i++){

            // la on declare une nouvelle instance
                    $comment = new Comment();
                    $comment->setContenu("Ceci est le contenu du commentaire");
                    $comment->setAuthor("Mohamd"); 
                    $comment->setDateComment(new \DateTime);
                    
                    $comment->setArticle($this->getReference('article-1'));
                    $manager->persist($comment);
        }

        $manager->flush();


    }

    public function getDependenciest(){
        [

            ArticleFixtures::class
        ];
    }
}
