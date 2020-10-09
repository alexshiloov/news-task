<?php


namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Входная dto на добавление обновление
 * Class NewsEntryDto
 * @package App\Dto
 */
class NewsEntryDto extends AbstractDto
{
    /**
     * @Assert\NotNull()
     * @var string
     */
    public $title;

    /** @var string|null */
    public $description;

    /**
     * @Assert\NotNull()
     * @var string
     */
    public $shortDescription;

    /**
     * @Assert\NotNull()
     * @var string
     */
    public $publishedAt;

    /**
     * Количество просмотров
     * @Assert\NotNull()
     * @Assert\Type("integer")
     * @var int
     */
    public $hits;

    /**
     * @Assert\NotNull()
     * @var bool
     */
    public $isActive;

    /**
     * @Assert\NotNull()
     * @var bool
     */
    public $isHide;
}
