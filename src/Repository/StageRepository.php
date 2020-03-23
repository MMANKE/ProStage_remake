<?php

namespace App\Repository;

use App\Entity\Stage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Stage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Stage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Stage[]    findAll()
 * @method Stage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stage::class);
    }


// ------------  TP1 - Requêtes sur mesure ------------------------
   /**
    * @return Stage[] Returns an array of Stage objects
    */
    public function findStagesByEntrepriseName($name) {
        return $this->createQueryBuilder('s')
            ->join('s.entreprise', 'e')
            ->andWhere('e.nom = :val')
            ->setParameter('val', $name)
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Stage[] Returns an array of Stage objects
     */
     public function findStagesByFormationName($name) {

          $entityManager = $this->getEntityManager();

          $requete = $entityManager->createQuery(
                'SELECT s
                 FROM App\Entity\Stage s
                 JOIN s.formations f
                 WHERE f.nom = :nomFormation'
              )
              ->setParameter('nomFormation', $name)
              ->execute();
              return $requete;
     }

     /**
      * @return Stage[] Returns an array of Stage objects
      */

      public function findAll() {

        $entityManager = $this->getEntityManager();

        $requete = $entityManager->createQuery(
            'SELECT s, e
             FROM App\Entity\Stage s
             JOIN s.entreprise e'
           )
           ->execute();
           return $requete;
      }


    /*
    public function findOneBySomeField($value): ?Stage
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
