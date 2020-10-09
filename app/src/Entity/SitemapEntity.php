<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class SitemapEntity
 * @package App\Entity
 * @ORM\Entity()
 * @ORM\Table(name="sitemap", schema="api")
 */
class SitemapEntity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * @var integer
     */
    private $id;

    /**
     * @ORM\Column(name="created_at", type="datetime")
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @ORM\Column(name="xml", type="string")
     * @var string
     */
    private $xml;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $dateTime
     * @return SitemapEntity
     */
    public function setCreatedAt(\DateTime $dateTime): self
    {
        $this->createdAt = $dateTime;
        return $this;
    }

    /**
     * @return string
     */
    public function getXml(): string
    {
        return $this->xml;
    }

    /**
     * @param string $xml
     * @return SitemapEntity
     */
    public function setXml(string $xml): SitemapEntity
    {
        $this->xml = $xml;
        return $this;
    }
}
