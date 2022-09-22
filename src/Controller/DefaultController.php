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

}
