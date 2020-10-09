<?php


namespace App\Controller;


use App\Dto\AbstractDto;
use FOS\RestBundle\Exception\InvalidParameterException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AbstractController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    /** @var ValidatorInterface */
    private $validator;

    /** @var \JsonMapper  */
    private $jsonMapper;

    public function __construct(ValidatorInterface $validator)
    {
        $this->jsonMapper = new \JsonMapper();
        $this->validator = $validator;
    }

    /**
     * @param Request $request
     * @param string $dtoClass
     * @throws \JsonMapper_Exception
     */
    protected function getDtoObject(Request $request, string $dtoClass): AbstractDto
    {
        $contents = json_decode($request->getContent());
        $dto = $this->jsonMapper->map($contents, new $dtoClass());
        $this->validateDto($dto);

        return $dto;
    }

    /**
     * @param AbstractDto $dto
     * @throws InvalidParameterException
     */
    protected function validateDto(AbstractDto $dto): void
    {
        /**
         * @var ConstraintViolation[] $errors
         */
        $errors = $this->validator->validate($dto);
        if (sizeof($errors) > 0) {
            throw new InvalidParameterException($errors[0]->getPropertyPath(). '. ' .$errors[0]->getMessage());
        }
    }
}
