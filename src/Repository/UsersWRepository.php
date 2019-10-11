<?php

namespace App\Repository;

use App\Entity\UsersW;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method UsersW|null find($id, $lockMode = null, $lockVersion = null)
 * @method UsersW|null findOneBy(array $criteria, array $orderBy = null)
 * @method UsersW[]    findAll()
 * @method UsersW[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsersWRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UsersW::class);
    }

    // /**
    //  * @return UsersW[] Returns an array of UsersW objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    public function addNewField($value): ?UsersW
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.email = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

}
