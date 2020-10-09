<?php


namespace App\Service;


use App\Dto\NewsDto;
use App\Entity\NewsEntity;
use App\Repository\NewsRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class NewsListService extends AbstractService
{
    /** @var NewsRepository */
    private $newsRepository;

    public function __construct(EntityManagerInterface $entityManager, LoggerInterface $logger)
    {
        parent::__construct($entityManager, $logger);
        $this->newsRepository = $this->entityManager->getRepository(NewsEntity::class);
    }

    /**
     * @param int $pageNo
     * @param int $pageSize
     * @return NewsDto[]
     * @throws \Doctrine\ORM\Query\QueryException
     */
    public function getNews(int $pageNo, int $pageSize): array
    {
        $criteria = Criteria::create()
            ->where(Criteria::expr()->eq('s.isActive', true))
            ->andWhere(Criteria::expr()->eq('s.isHide', false))
            ->andWhere(Criteria::expr()->lte('s.publishedAt', new \DateTime()))
            ->orderBy(['s.publishedAt' => SORT_DESC])
            ->setFirstResult($pageSize * ($pageNo - 1))
            ->setMaxResults($pageSize);

        $entities = $this->newsRepository->findByCriteria($criteria);
        $dtos = [];
        foreach ($entities as $entity) {
            $dtos[] = $entity->toDto();
        }

        return $dtos;
    }

    /**
     * @param string $slug
     * @return NewsDto
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\Query\QueryException
     */
    public function getNewsBySlug(string $slug): NewsDto
    {
        /** Получаю название новости по ссылке */
        $title = NewsEntity::getTitleFromSlug($slug);
        $criteria = Criteria::create()
            ->where(Criteria::expr()->eq('s.title', $title))
            ->andWhere(Criteria::expr()->eq('s.isActive', true))
            ->andWhere(Criteria::expr()->lte('s.publishedAt', new \DateTime()));

        $newsEntity = $this->newsRepository->findOneByCriteria($criteria);
        if (empty($newsEntity)) {
            throw new NotFoundHttpException('Новость не найдена');
        }

        return $newsEntity->toDto();
    }
}
