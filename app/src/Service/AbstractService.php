<?php


namespace App\Service;


use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class AbstractService
{
    /** @var EntityManagerInterface  */
    protected $entityManager;

    /** @var LoggerInterface  */
    protected $logger;

    public function __construct(EntityManagerInterface $entityManager, LoggerInterface $logger)
    {
        $this->entityManager = $entityManager;
        $this->logger = $logger;
    }
}
