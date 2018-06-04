<?php

namespace App\Repository;

use App\Entity\Gift;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Gift|null find($id, $lockMode = null, $lockVersion = null)
 * @method Gift|null findOneBy(array $criteria, array $orderBy = null)
 * @method Gift[]    findAll()
 * @method Gift[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GiftRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Gift::class);
    }

//    /**
//     * @return Gift[] Returns an array of Gift objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Gift
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
//    public function findByIdAndUuid($id,$uuid)
//    {
//        $qb = $this->createQueryBuilder('g');
//        return $qb
//            ->leftJoin('gift_list', 'gl', 'ON', 'gl.id = g.user_id')
//            ->where('p.dateVFin IS NULL')
//            ->andWhere('g.uuid=:uuid')
//            ->addOrderBy('t.cp', 'DESC')
//            ->setParameter('uuid', $uuid)
//            ;
//    }
}
