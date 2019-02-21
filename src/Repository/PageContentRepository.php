<?php

namespace App\Repository;

use App\Entity\PageContent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PageContent|null find($id, $lockMode = null, $lockVersion = null)
 * @method PageContent|null findOneBy(array $criteria, array $orderBy = null)
 * @method PageContent[]    findAll()
 * @method PageContent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PageContentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PageContent::class);
    }

    /**
     * @return PageContent[] Returns an array of PageContent objects
     */
    public function findPublished()
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.router <> :val1')
            ->andWhere('p.published = :val2')
            ->setParameter('val1', "start")
            ->setParameter('val2', true)
            ->orderBy('p.pageOrder', 'ASC')
            //->setMaxResults(10)
            ->distinct()
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return PageContent[] Returns an array of PageContent objects
     */
    public function findGreaterOrder($order)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.pageOrder >= :val')
            ->setParameter('val', $order)
            //->orderBy('p.id', 'ASC')
            //->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    

    /*
    public function findOneBySomeField($value): ?PageContent
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
