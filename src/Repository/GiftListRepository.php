<?php

namespace App\Repository;

use App\Entity\GiftList;
use App\Entity\Gift;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method GiftList|null find($id, $lockMode = null, $lockVersion = null)
 * @method GiftList|null findOneBy(array $criteria, array $orderBy = null)
 * @method GiftList[]    findAll()
 * @method GiftList[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GiftListRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, GiftList::class);
    }

    public function findByUuidUser($value)
    {

        return $this->createQueryBuilder('g')
            ->innerJoin(Gift::class, 'gi', 'WITH', 'gi.userId = g.id')
            ->select('gi', 'g')
            ->andWhere('g.uuid = :uuid')
            ->setParameter('uuid', $value)
            ->getQuery()
            ->getResult()
            ;

        //var_dump($t);
    }


    /*
    public function findOneBySomeField($value): ?GiftList
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
