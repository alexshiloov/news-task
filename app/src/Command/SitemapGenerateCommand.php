<?php


namespace App\Command;


use App\Entity\NewsEntity;
use App\Entity\SitemapEntity;
use App\Repository\NewsRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SitemapGenerateCommand extends Command
{
    private $entityManager;
    private $logger;

    /** @var NewsRepository  */
    private $newsRepository;

    /**
     * SitemapGenerateCommand constructor.
     * @param string|null $name
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        LoggerInterface $logger,
        string $name = null)
    {
        parent::__construct($name);
        $this->entityManager = $entityManager;
        $this->logger = $logger;
        $this->newsRepository = $this->entityManager->getRepository(NewsEntity::class);
    }

    protected function configure()
    {
        $this->setName('app:generate-sitemap');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void
     * @throws \Doctrine\ORM\Query\QueryException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $returnValue = 0;
        sleep(2);
        try {
            $criteria = Criteria::create()
                ->where(Criteria::expr()->eq('s.isActive', true))
                ->andWhere(Criteria::expr()->eq('s.isHide', false))
                ->andWhere(Criteria::expr()->lte('s.publishedAt', new \DateTime()))
                ->orderBy(['s.publishedAt' => SORT_DESC]);

            $entities = $this->newsRepository->findByCriteria($criteria);

            $xml = '<?xml version="1.0" encoding="UTF-8"?>
                <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
            foreach ($entities as $entity) {
                $xml .= '<url>
                        <loc>'.$entity->getSlug().'</loc>
                        <lastmod>'.$entity->getUpdatedAt().'</lastmod>
                      </url>';
            }
            $xml .= '</urlset>';

            $siteMapEntity = (new SitemapEntity())
                ->setXml(htmlspecialchars($xml))
                ->setCreatedAt(new \DateTime());

            $this->entityManager->persist($siteMapEntity);
            $this->entityManager->flush();
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            $returnValue = 1;
        }

        return $returnValue;
    }
}
