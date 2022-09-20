<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Service\VerificationComment;
use App\Entity\Comment;

class VerificationCommentTest extends TestCase
{
    protected $comment;
    protected function setUp(): void{
        // on declare qu'une instance de commentaire, 

        $this->comment = new Comment();
    }





    public function testContientMotIterdit(){ //on va varier le contenu de notre commentaire et tester a chaque fois 
        $service = new VerificationComment();
        

       $this->comment->setContenu("ceci est un commentaire avec mauvais");
        $result = $service->CommentaireNonAutorise($this->comment);

        $this->assertTrue($result);
    }

    public function testNeContientPasDeMotInterdit(){
        $service = new VerificationComment();
       

        $this->comment->setContenu("ceci est un commentaire");
        $result = $service->CommentaireNonAutorise($this->comment);

        $this->assertFalse($result);
    }
}
