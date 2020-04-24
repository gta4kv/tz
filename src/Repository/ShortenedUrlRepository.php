<?php

namespace App\Repository;

use App\Entity\ShortenedUrl;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ShortenedUrl|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShortenedUrl|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShortenedUrl[]    findAll()
 * @method ShortenedUrl[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShortenedUrlRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShortenedUrl::class);
    }

    /**
     * @param int $id
     * @return ShortenedUrl|null
     *
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findOneByIdNotExpired(int $id): ?ShortenedUrl
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.id = :id')
            ->setParameter('id', $id)
            ->andWhere('s.expires_at is null or s.expires_at > CURRENT_TIMESTAMP()')
            ->getQuery()
            ->getSingleResult();
    }
}
