<?php

namespace App\Repository;

use App\Entity\ItemDelivery;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ItemDelivery|null find($id, $lockMode = null, $lockVersion = null)
 * @method ItemDelivery|null findOneBy(array $criteria, array $orderBy = null)
 * @method ItemDelivery[]    findAll()
 * @method ItemDelivery[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ItemDeliveryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ItemDelivery::class);
    }

    // /**
    //  * @return ItemDelivery[] Returns an array of ItemDelivery objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ItemDelivery
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
