<?php


namespace App\Repository;


use App\Entity\NewsEntity;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityRepository;

class NewsRepository extends EntityRepository
{
    /**
     * @param Criteria $criteria
     * @return NewsEntity|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\Query\QueryException
     */
    public function findOneByCriteria(Criteria $criteria): ?NewsEntity
    {
        return $this->getEntityManager()->createQueryBuilder()
            ->select('s')
            ->from(NewsEntity::class, 's')
            ->addCriteria($criteria)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param Criteria $criteria
     * @return NewsEntity[]
     * @throws \Doctrine\ORM\Query\QueryException
     */
    public function findByCriteria(Criteria $criteria): array
    {
        return $this->getEntityManager()->createQueryBuilder()
            ->select('s')
            ->from(NewsEntity::class, 's')
            ->addCriteria($criteria)
            ->getQuery()
            ->getResult();
    }
}
