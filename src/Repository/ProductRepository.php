<?php

namespace App\Repository;

use App\Classe\Search;
use App\Entity\Product;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * Requete qui permet de récupérer les produits suivant les filtres
     * 
     * @param Search $search
     * @return Product()
     */
    public function findWithSearch(Search $search)
    {
      $query = $this->createQueryBuilder('product')
                     ->select('category', 'product')
                     ->join('product.category', 'category');

               if (!empty($search->categories)) {
                 $query = $query
                 ->andWhere('category.id IN (:category)')
                 ->setParameter('category', $search->categories);
               }

               if (!empty($search->string)) {
                  $query = $query
                  ->andWhere('product.name LIKE :name')
                  ->setParameter('name', "%{$search->string}%");
                }
                  
         return $query->getQuery()->getResult();
    }

    /**
     * @return Product[] Returns an array of Product objects
     */
    public function findByIsBest($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.isBest = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }


    /*
    public function findOneBySomeField($value): ?Product
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
