<?php

namespace App\Service;

use App\Entity\Comment;

class VerificationComment
{
    // je créé un serivce qui va interdire les insultes
    public function CommentaireNonAutorise(Comment $comment)
    {
        // je declare un tableau de mots non autorisé
        $nonAutorise = [
            "mauvais",
            "Nique ta mère",
            "fdp",
            "moche",
            "Rémy",
            "roxan",
            "ruben",
            "nicolas",
            "jasmine" 

        ];
        // ici je vais boucler les mots qui ne sont pas autorisé
        foreach ($nonAutorise as $word) {

            //   a chaque fois cava verifier si notre mots nosautorisé se trouve dans notre contenu

            if (str_contains($comment->getContenu(), $word)) {
                // si c'est le cas  on
                return true;
                //    et on lui dis que le mots n'est pas autorisé
            }
        }
        //   sinon
        return false;
    }
}
