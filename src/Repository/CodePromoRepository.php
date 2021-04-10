<?php

namespace App\Repository;

use App\Entity\CodePromo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CodePromo|null find($id, $lockMode = null, $lockVersion = null)
 * @method CodePromo|null findOneBy(array $criteria, array $orderBy = null)
 * @method CodePromo[]    findAll()
 * @method CodePromo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CodePromoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CodePromo::class);
    }

     /**
      * @return CodePromo[] Returns an array of CodePromo objects
      */
    
    public function searchCodePromo($data,$vendeurId)
    {
        return $this->createQueryBuilder('code')
            ->andWhere('code.nom = :data')
            ->andWhere('code.vendeurId IN (:val)') // On lui fait parcourir le tableau des vendeurs 
            ->setParameter('data', $data)
            ->setParameter('val',  $vendeurId)
            ->getQuery()
            ->getResult()
        ;
    }


    
    // public function findOneBySomeField($value): ?CodePromo
    // {
    //     return $this->createQueryBuilder('c')
    //         ->andWhere('c.exampleField = :val')
    //         ->setParameter('val', $value)
    //         ->getQuery()
    //         ->getOneOrNullResult()
    //     ;
    // }
    
}
