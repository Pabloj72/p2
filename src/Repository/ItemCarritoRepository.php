<?php

namespace App\Repository;

use App\Entity\ItemCarrito;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ItemCarrito>
 *
 * @method ItemCarrito|null find($id, $lockMode = null, $lockVersion = null)
 * @method ItemCarrito|null findOneBy(array $criteria, array $orderBy = null)
 * @method ItemCarrito[]    findAll()
 * @method ItemCarrito[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ItemCarritoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ItemCarrito::class);
    }

//    /**
//     * @return ItemCarrito[] Returns an array of ItemCarrito objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ItemCarrito
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
