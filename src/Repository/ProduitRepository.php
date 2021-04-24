<?php

namespace App\Repository;

use App\Entity\Produit;
use App\Entity\Recherche;
use App\Form\RechercheType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Produit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produit[]    findAll()
 * @method Produit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produit::class);
    }

    public function findBest()
    {
        return $this->createQueryBuilder('produits')
        ->orderBy('produits.nbrVendu', 'DESC')
        ->setMaxResults(5)
        ->getQuery()
        ->getResult()
    ;
    }
    
    public function findBestVendeur()
    {
        return $this->createQueryBuilder('produits')
        ->groupBy('produits.vendeur')
        ->orderBy('SUM(produits.nbrVendu)', 'DESC')
        ->setMaxResults(5)
        ->getQuery()
        ->getResult()
    ;
    }
    
    public function AllProducts()
        {      
            return $this->createQueryBuilder('produits');      
        }


    public function Recherche(Recherche $recherche, $vendeurId)
    {
        $query = $this->AllProducts();  
        
        $query = $query
        ->where('produits.vendeur = :vendeurId')
        ->setParameter('vendeurId', $vendeurId);
  
        
        if ($recherche->getNom()){
            $query = $query
            ->andWhere('produits.nom = :nom')
            ->setParameter('nom',$recherche->getNom());
                           
        }

        if ($recherche->getPrixMin()){
            $query = $query
            ->andWhere('produits.prixUnitaireHT >= :prixMin')
            ->setParameter('prixMin',$recherche->getPrixMin());          
        }
        if ($recherche->getPrixMax()){
            $query = $query
            ->andWhere('produits.prixUnitaireHT <= :prixMax')
            ->setParameter('prixMax',$recherche->getPrixMax());          
        }


        if ($recherche->getStockMax()){
            $query = $query
            ->andWhere('produits.stock <= :stockMax')
            ->setParameter('stockMax',$recherche->getStockMax());          
        }
        if ($recherche->getStockMin()){
            $query = $query
            ->andWhere('produits.stock >= :stockMin')
            ->setParameter('stockMin',$recherche->getStockMin());          
        }


        return $query->getQuery()
        ->getResult();


        }

        












    //    dump($data);
    //         return $this->createQueryBuilder('produits')
    
    //         ->andwhere('produits.vendeur = :vendeurId')
    //         ->andWhere('produits.nom = :nom')
    //         ->andWhere('produits.prixUnitaireHT >= :prixMin')
    //         ->setParameters([
    //             'vendeurId'=> $vendeurId,
    //             'nom'=>$data->getNom(),
    //             'prixMin'=>$data->getPrixMin(),
                
    //              ])
    //         ->getQuery()
    //         ->getResult()
    //         ;
    //Ca marche pour 1 mais pas pour plusieurs combinés

        // if ($recherche->getNom()){
        //     $query = $query
        //     ->andwhere('produits.nom = :nom')
        //     ->setParameter('nom', $recherche->getNom());
        // }





    

    // /**
    //  * @return Produit[] Returns an array of Produit objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Produit
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
