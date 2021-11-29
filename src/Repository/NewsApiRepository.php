<?php

namespace App\Repository;

use App\Entity\NewsApi;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NewsApi|null find($id, $lockMode = null, $lockVersion = null)
 * @method NewsApi|null findOneBy(array $criteria, array $orderBy = null)
 * @method NewsApi[]    findAll()
 * @method NewsApi[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewsApiRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NewsApi::class);
    }

    /**
     * @param $searchtitle
     * @return Query
     */

    public function findbyName($searchtitle): Query
    {
        return $this->createQueryBuilder('n')
            ->where('n.author LIKE :val')
            ->setParameter('val', $searchtitle)
            ->getQuery();
    }


    public function findByUrl($url)
    {
        $result = $this->createQueryBuilder('n')
            ->andWhere('n.url = :val')
            ->setParameter('val', $url)
            ->getQuery();
    }

    /**
     * @throws NonUniqueResultException
     */
    public function findByLink($url)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.url = :val')
            ->setParameter('val', $url)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
