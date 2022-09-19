<?php

namespace App\Controller;


use App\Entity\Article;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Form\ArticleType;
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
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
  // / qui va lister l'ensemble de nos articles
  /** 
   *@Route ("/", name="liste_articles", methods={"GET"}) 
   */
  public function listeArticles(ArticleRepository $articleRepository): Response
  {

    $article = $articleRepository->findByTitre('Article N°.1');

    // dump($article);die;
    $articles = $articleRepository->findAll();

    return $this->render('default/index.html.twig', [

      'articles' => $articles


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
  public function vueArticle(Article $article, Request $request, EntityManagerInterface $manager)
  {
    $comment = new Comment();
    $comment->setArticle($article);

    $form = $this->createForm(CommentType::class, $comment);

    $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid()){
      $manager->persist($comment);
      $manager->flush();
      return $this->redirectToRoute('vue_article', ['id' => $article->getId()]);
    }
  
    return $this->render('default/vue.html.twig', [
      'article' => $article,
      'form' => $form->createView()
    ]);
  }

  /**
   * @Route("/article/ajouter", name="ajout_article")
   */
  public function ajouter(Request $request, EntityManagerInterface $manager)
  {
    //  Quand on arrive sur la page ajouter un article 
    // on crée un nouvel article
    $article = new Article();

    //  cet nouvel article ^^ on l'envoi au formulaire 

    $form = $this->createForm(ArticleType::class, $article); // le formulaire va mapper les champs du formulaire avec l'entité quon va lui passer

// quand on va soumettre le form, il va recuperer la requete et faire son taff et envoyer a notre entité article
    $form->handleRequest($request);

// on verifie si la champ a  bien été valide
    if ($form->isSubmitted() && $form->isValid()) {

      $manager->persist($article);

      $manager->flush();

      return $this->redirectToRoute('liste_articles');
    }


    return $this->render('default/ajout.html.twig', [
      'form' => $form->createView()
      // la fonction createview peremt de créer la vue coreespondance a ce formulaire 
    ]);
  }
}

    //  (


// ANCIENNE VERSION


    // si on veut rajouter des champs a notre formulaire on utilise la fonction add
    // la fonction add() se met a la suite de la fontion creatFormBuilder : $form->createFormBuilder()->add(...)

    // $form = $this->createFormBuilder()
    // ->add('titre', TextType::class, [
    //   'label' => "Titre de l'article"
    // ])
    // ->add('contenu', TextareaType::class)
    // ->add('dateCreation', DateType::class, [
    //   'widget' => 'single_text',
    //   // 'input' => 'datetime'
    // ])
    
    // ->getForm();


// )

//cava permettre de dire au formulaire de recuperer la requete et les données qui ont été envoyé a la bdd
    // ici on verifie sur le form a bien éte soumis 

   
//        $article = new Article();
//        $article->setTitre($form->get('titre')->getData());
//        $article->setContenu($form->get('contenu')->getData());
//        $article->setDateCreation($form->get('dateCreation')->getData());

//        //on appelle notre categorie

//        $category = $categoryRepository->findOneBy([
//         'name' => 'Sport'
//        ]);

//        $article->addCategory($category);
// //on a un nouvel objet donc on va le persister
//        $manager->persist($article);

//        $manager->flush();

//        return $this->redirectToRoute('liste_articles');





  





    // $article = new Article();
    // $article->setTitre("Titre de l'article");
    // $article->setContenu("Ceci est le contenu de l'article");
    // $article->setDateCreation(new \DateTime());

    // $manager->persist($article); 
    // $manager->flush();
    // die;
    //  dump($article);die;
