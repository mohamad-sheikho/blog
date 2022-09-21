<?php

namespace App\Controller;


use App\Entity\Article;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Form\ArticleType;
use App\Service\VerificationComment as VerificationComment;
use App\Repository\ArticleRepository as ArticleRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
  // / qui va lister l'ensemble de nos articles
  /** 
   *@Route ("/", name="liste_articles", methods={"GET"}) 
   */
  public function listeArticles(ArticleRepository $articleRepository): Response
  {
    $articles = $articleRepository->findBy([
      'state' => 'publier'
    ]);

    return $this->render('default/index.html.twig', [

      'articles' => $articles,
      'brouillon' => false


    ]);
  }

  // /12 afficher l'arcticle 

  //  une astuce plus simple ou plutot un raccourci pour ne pas avoir a appele le repository lorsqu'on va afficher un element, sa s'apl les (paramconverter)

  // Donc c'est pllus comme ca mais plutot comme ca 
  // ANCIEN
  // public function vueArticle(ArticleRepository $articleRepository, $id)
  // {
  //   // $article = $articleRepository->findByDateCreation(new \DateTime());

  //   $article = $articleRepository->find($id);


  //   // dump( $article);die;
  //   return $this->render('default/vue.html.twig', [
  //     'article' => $article
  //   ]); 

  // NOUVEAU

  /** 
   *@Route("/{id}", name="vue_article", requirements={"id"="\d+"}, methods={"GET", "POST"}) 
   */
  public function vueArticle(Article $article, Request $request, EntityManagerInterface $manager, VerificationComment $verifService )
  {

    // $this->addFlash("danger", "Le commentaire contient un mot interdit !");
    $comment = new Comment();
    $comment->setArticle($article);

    $form = $this->createForm(CommentType::class, $comment);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid())
     {

      if ($verifService->CommentaireNonAutorise($comment) === false) {

        $manager->persist($comment);
        $manager->flush();
        return $this->redirectToRoute('vue_article', ['id' => $article->getId()]);
      }
      $this->addFlash(
        'danger',
        'Votre commentaire contient des mots interdit !'
    );
      
      
    }

    return $this->render('default/vue.html.twig', [
      'article' => $article,
      'form' => $form->createView()
    ]);
  }


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
        $article->setState('publier');
      }
// la on va verifier que le getid soit null
      if($article->getId() ===null){
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
