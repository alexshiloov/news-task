<?php


namespace App\Dto;


/**
 * Class NewsDto
 * @package App\Dto
 */
class NewsDto extends NewsEntryDto
{
    /** @var int */
    public $id;

    /** @var string */
    public $createdAt;

    /** @var string|null */
    public $updatedAt;

    /**
     * Url новости
     * @var string
     */
    public $slug;
}
