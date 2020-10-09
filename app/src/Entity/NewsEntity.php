<?php


namespace App\Entity;

use App\Kernel;
use Doctrine\ORM\Mapping as ORM;
use App\Dto\NewsDto;

/**
 * Class NewsEntity
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\NewsRepository")
 * @ORM\Table(name="news", schema="api")
 */
class NewsEntity extends TransferableEntity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * @var integer
     */
    private $id;

    /**
     * @ORM\Column(name="title", type="string")
     * @var string
     */
    private $title;

    /**
     * @ORM\Column(name="description", type="string")
     * @var string|null
     */
    private $description;

    /**
     * @ORM\Column(name="short_description", type="string")
     * @var string
     */
    private $shortDescription;

    /**
     * @ORM\Column(name="created_at", type="datetime")
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @ORM\Column(name="updated_at", type="datetime")
     * @var \DateTime|null
     */
    private $updatedAt;

    /**
     * @ORM\Column(name="published_at", type="datetime")
     * @var \DateTime
     */
    private $publishedAt;

    /**
     * @ORM\Column(name="hits", type="integer")
     * @var int
     */
    private $hits;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     * @var boolean
     */
    private $isActive;

    /**
     * @ORM\Column(name="is_hide", type="boolean")
     * @var bool
     */
    private $isHide;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return NewsEntity
     */
    public function setTitle(string $title): NewsEntity
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return NewsEntity
     */
    public function setDescription(?string $description): NewsEntity
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getShortDescription(): string
    {
        return $this->shortDescription;
    }

    /**
     * @param string $shortDescription
     * @return NewsEntity
     */
    public function setShortDescription(string $shortDescription): NewsEntity
    {
        $this->shortDescription = $shortDescription;
        return $this;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt->format(DATE_ISO8601);
    }

    /**
     * @param \DateTime $createdAt
     * @return NewsEntity
     */
    public function setCreatedAt(\DateTime $createdAt): NewsEntity
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUpdatedAt(): ?string
    {
        if (empty($this->updatedAt)) {
            return null;
        }
        return $this->updatedAt->format(DATE_ISO8601);
    }

    /**
     * @param \DateTime|null $updatedAt
     * @return NewsEntity
     */
    public function setUpdatedAt(?\DateTime $updatedAt): NewsEntity
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @return string
     */
    public function getPublishedAt(): string
    {
        return $this->publishedAt->format(DATE_ISO8601);
    }

    /**
     * @param string $publishedAt
     * @return NewsEntity
     */
    public function setPublishedAt(string $publishedAt): NewsEntity
    {
        $this->publishedAt = \DateTime::createFromFormat(DATE_ISO8601, $publishedAt);
        return $this;
    }

    /**
     * @return int
     */
    public function getHits(): int
    {
        return $this->hits;
    }

    /**
     * @param int $hits
     * @return NewsEntity
     */
    public function setHits(int $hits): NewsEntity
    {
        $this->hits = $hits;
        return $this;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->isActive;
    }

    /**
     * @param bool $isActive
     * @return NewsEntity
     */
    public function setIsActive(bool $isActive): NewsEntity
    {
        $this->isActive = $isActive;
        return $this;
    }

    /**
     * @return bool
     */
    public function isHide(): bool
    {
        return $this->isHide;
    }

    /**
     * @param bool $isHide
     * @return NewsEntity
     */
    public function setIsHide(bool $isHide): NewsEntity
    {
        $this->isHide = $isHide;
        return $this;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return Kernel::HTTP_BASE_SLUG. str_replace(" ", "%%", $this->title);
    }

    /**
     * Получаю название новости по ссылке
     *
     * @param string $slug
     * @return string
     */
    public static function getTitleFromSlug(string $slug): string
    {
        $title = str_replace(Kernel::HTTP_BASE_SLUG, "", $slug);
        return str_replace("%%", " ", $title);
    }

    public function getEntityDtoObject()
    {
        return new NewsDto();
    }
}
