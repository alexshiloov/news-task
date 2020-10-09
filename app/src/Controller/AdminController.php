<?php


namespace App\Controller;


use App\Dto\NewsEntryDto;
use App\Service\AdminService;
use Cocur\BackgroundProcess\BackgroundProcess;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AdminController extends AbstractController
{
    private $adminService;

    public function __construct(
        ValidatorInterface $validator,
        AdminService $adminService
    )
    {
        parent::__construct($validator);
        $this->adminService = $adminService;
    }

    /**
     * Добавление новости
     * @Route(path="/news", methods={"POST"})
     *
     * @param Request $request
     * @param KernelInterface $kernel
     * @return JsonResponse
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     * @throws \JsonMapper_Exception
     */
    public function create(Request $request)
    {
        /** @var NewsEntryDto $entryDto */
        $entryDto = $this->getDtoObject($request, NewsEntryDto::class);
        $returnDto = $this->adminService->saveNews($entryDto);
        $this->runGenerateSitemap();

        return new JsonResponse(['result' => $returnDto]);
    }

    /**
     * Обновление новости
     * @Route(path="/news/{id}", methods={"PUT"})
     *
     * @param Request $request
     * @param int $id
     * @param KernelInterface $kernel
     * @return JsonResponse
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     * @throws \JsonMapper_Exception
     */
    public function update(Request $request, int $id)
    {
        /** @var NewsEntryDto $entryDto */
        $entryDto = $this->getDtoObject($request, NewsEntryDto::class);
        $returnDto = $this->adminService->saveNews($entryDto, $id);
        $this->runGenerateSitemap();

        return new JsonResponse(['result' => $returnDto]);
    }

    /**
     * Удаление новости
     * @Route(path="/news/{id}", methods={"DELETE"})
     * @param int $id
     * @return JsonResponse
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function delete(int $id)
    {
        $this->adminService->deleteNews($id);
        $this->runGenerateSitemap();

        return new JsonResponse(['result' => []]);
    }

    private function runGenerateSitemap()
    {
        $process = new BackgroundProcess('php ../bin/console app:generate-sitemap');
        $process->run();
    }
}
