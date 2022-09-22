<?php

namespace App\Controller;


use App\Entity\Article;
use Symfony\Component\Form;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Form\ArticleType;
use App\Service\VerificationComment as VerificationComment;
use App\Repository\ArticleRepository as ArticleRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
     // LA PAGE AJOUTER UN ARTICLE 
  /**
   * @Route("/article/ajouter", name="ajout_article")
   * @Route("/article/{id}/edition", name="edition_article", requirements={"id"="\d+"}, methods={"GET", "POST"})
   */
  public function ajouter(Article $article = null, Request $request, EntityManagerInterface $manager)
  // le service request  va me fournir des donnée sur la requete qui a été faite  par le client 
  // le service  EntityManagerInterface permet de manipuler nos données
  {

    // on va checker si  notre route article est null
    if($article === null){ // si l'article est null on  crée une nouvelle instance d'article

    // Quand on arrive sur la page ajouter un article 
    // on crée un nouvel article
    $article = new Article();
    }

    //  cet nouvel article ^^ on l'envoi au formulaire 

    $form = $this->createForm(
      ArticleType::class,
      $article

    ); // le formulaire va mapper les champs du formulaire avec l'entité quon va lui passer

    // quand on va soumettre le form, il va recuperer la requete et faire son taff et envoyer a notre entité article
    $form->handleRequest($request);

    // on verifie si la champ a  bien été valide
    if ($form->isSubmitted() && $form->isValid()) {
      



      if($form->get('brouillon')->isClicked()){
        $article->setState('brouillon');

      }
      else{
        $article->setState('a publier');
      }
// la on va verifier que le getid soit null
      if($article->getId() === null){
        // on sait que notre article n'existe pas en bdd et on va le mettre
        $manager->persist($article);
      }

      

      $manager->flush();

      return $this->redirectToRoute('liste_articles');
    }


    return $this->render('default/ajout.html.twig', [
      'form' => $form->createView()
      // la fonction createview peremt de créer la vue coreespondance a ce formulaire 
    ]);
  }

  /**
   * @Route("/article/brouillon", name="brouillon_article")
   */
  public function brouillon(ArticleRepository $articleRepository){
    $articles = $articleRepository->findBy([
      'state' => 'brouillon'
    ]);

    return $this->render('default/index.html.twig', [

      'articles' => $articles,
      'brouillon' => true


    ]);

  }
}
