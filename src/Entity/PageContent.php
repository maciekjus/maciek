<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PageContentRepository")
 */
class PageContent
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $router;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $menutext;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $author;

    /**
     * @ORM\Column(type="datetime")
     */
    private $modyf;

    /**
     * @ORM\Column(type="boolean")
     */
    private $published;

    /**
     * @ORM\Column(type="boolean")
     */
    private $mainpage;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRouter(): ?string
    {
        return $this->router;
    }

    public function setRouter(string $router): self
    {
        $this->router = $router;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getMenutext(): ?string
    {
        return $this->menutext;
    }

    public function setMenutext(?string $menutext): self
    {
        $this->menutext = $menutext;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(?string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getModyf(): ?\DateTimeInterface
    {
        return $this->modyf;
    }

    public function setModyf(\DateTimeInterface $modyf): self
    {
        $this->modyf = $modyf;

        return $this;
    }

    public function getPublished(): ?bool
    {
        return $this->published;
    }

    public function setPublished(bool $published): self
    {
        $this->published = $published;

        return $this;
    }

    public function getMainpage(): ?bool
    {
        return $this->mainpage;
    }

    public function setMainpage(bool $mainpage): self
    {
        $this->mainpage = $mainpage;

        return $this;
    }
}
