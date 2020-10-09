<?php


namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\NewsListService;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class FrontController extends AbstractController
{
    private $newsListService;

    public function __construct(ValidatorInterface $validator, NewsListService $newsListService)
    {
        parent::__construct($validator);
        $this->newsListService = $newsListService;
    }

    /**
     * Получение списка новостей
     * @Route(path="/news",  name="getNews", methods={"GET"})
     *
     * @QueryParam(name="pageNo", requirements="\d+", strict=true, allowBlank=false)
     * @QueryParam(name="pageSize", requirements="\d+", strict=true, allowBlank=false)
     * @param int $pageNo
     * @param int $pageSize
     * @return JsonResponse
     * @throws \Doctrine\ORM\Query\QueryException
     */
    public function getNews(int $pageNo, int $pageSize)
    {
        return new JsonResponse(['result' => $this->newsListService->getNews($pageNo, $pageSize)]);
    }

    /**
     * Получение новости по ссылке
     * @Route(path="/news/slug", methods={"GET"})
     *
     * @QueryParam(name="slug", strict=true, allowBlank=false)
     *
     * @param string $slug
     * @return JsonResponse
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\Query\QueryException
     */
    public function getNewsBySlug(string $slug)
    {
        return new JsonResponse(['result' => $this->newsListService->getNewsBySlug($slug)]);
    }
}
