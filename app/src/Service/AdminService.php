<?php


namespace App\Service;


use App\Dto\NewsDto;
use App\Dto\NewsEntryDto;
use App\Entity\NewsEntity;
use App\Repository\NewsRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AdminService extends AbstractService
{
    /** @var NewsRepository */
    private $newsRepository;

    public function __construct(EntityManagerInterface $entityManager, LoggerInterface $logger)
    {
        parent::__construct($entityManager, $logger);
        $this->newsRepository = $this->entityManager->getRepository(NewsEntity::class);
    }

    /**
     * Сохранение\обновление новости
     *
     * @param NewsEntryDto $entryDto
     * @param int|null $id
     * @return \App\Dto\AbstractDto
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function saveNews(NewsEntryDto $entryDto, ?int $id = null)
    {
        /** Проверяем что новость с таким заголовком уже существует */
        $criteria = Criteria::create()
            ->where(Criteria::expr()->eq('s.title', $entryDto->title))
            ->andWhere(Criteria::expr()->neq('s.id', $id));
        $newsEntity = $this->newsRepository->findOneByCriteria($criteria);
        if (!empty($newsEntity)) {
            throw new BadRequestHttpException('Новость с таким заголовком уже существует');
        }

        $this->entityManager->beginTransaction();
        try {
            if (!empty($id)) {
                $newsEntity = $this->getNewsEntityById($id);
                $newsEntity->fill($entryDto)
                    ->setUpdatedAt(new \DateTime());
            } else {
                $newsEntity = (new NewsEntity())
                    ->fill($entryDto)
                    ->setCreatedAt(new \DateTime())
                    ->setUpdatedAt(new \DateTime());
                $this->entityManager->persist($newsEntity);
            }

            $this->entityManager->flush();
            $this->entityManager->commit();
        } catch (NotFoundHttpException $e) {
            throw $e;
        } catch (\Exception $e) {
            $this->entityManager->rollback();
            $this->logger->error($e->getMessage());
            throw new \Exception('Ошибка при сохранении новости');
        }

        return $this->getNewsEntityById($newsEntity->getId())->toDto();
    }

    /**
     * @param int $id
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function deleteNews(int $id)
    {
        $newsEntity = $this->getNewsEntityById($id);
        $this->entityManager->remove($newsEntity);
        $this->entityManager->flush();
    }

    /**
     * @param int $id
     * @return NewsDto
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    private function getNewsEntityById(int $id): NewsEntity
    {
        $criteria = Criteria::create()->where(Criteria::expr()->eq('s.id', $id));
        $newsEntity = $this->newsRepository->findOneByCriteria($criteria);
        if (empty($newsEntity)) {
            throw new NotFoundHttpException('Новость не может быть найдена');
        }

        return $newsEntity;
    }
}
