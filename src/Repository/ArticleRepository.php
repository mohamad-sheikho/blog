<?php


//  les repository permettenet de requeter la base de données. soit en utilisant des fonctionq prédefinis par symfony (find,findoneby,...)
// soit en creant nos propres requetes grace au querybuilder

 
namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr\Select;

/**
 * @extends ServiceEntityRepository<Article>
 *
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function findByDateCreation(\DateTime $date){
        $qb = $this->createQueryBuilder('a');
        // Donc le a de alias sert a recuperer toute nos entités
        $qb->select('a');
        // pour créer un parametre on met : , Donc sa veut dire quon dis au querrybuilder que a cet endroit on va attendre a un parametre specifique.
        $qb->where('a.dateCreation = :date');
        // pour donner une valeur a ce parametre on utilise cette fonction 
        $qb->setParameter('date', $date->format('Y-m-d'));

        // ^^^^ don en haut on a créer notre requete!!

        // et mtn je retourne le resultat de cet requete  
        // la le getQuerry va transformer cette querrybuilder en query sql 
        return $qb->getQuery()->getResult();

    }

    public function findByTitre($titre){
        $qb = $this->createQueryBuilder('a'); 
        $qb->select('a');
        $qb->where('a.titre = :titre');
        $qb->setParameter('titre', $titre);
        $qb->setMaxResults(1);

        return $qb->getQuery()->getOneOrNullResult();
    }

    public function add(Article $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Article $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Article[] Returns an array of Article objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Article
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}


//  Donc ce quil faut retenir sur les repository permettent de faire différentes requettes en base de donnée 
// pour aller récuperer des objets que symfony a deja developpées certaine fonctionnalité qui sont utilisées dans 80% des cas, que ce soit pour aller recuperer un seul element ou bien un liste, 
// donc find et findoneby pour un seul 
// et findall pour recuperer tout les elements *
// findby pour recuperer une liste d'elements qui vont etre filtré 

// si sa nous convient pas, on a la possibilité de créer nos propre requete  