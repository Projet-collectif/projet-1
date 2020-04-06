<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BlogRepository")
 */
class Blog
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", options={"unsigned"=true})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Compte", inversedBy="blogs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $compte;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @ORM\Column(type="boolean")
     */
    private $publish;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $metadesc;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $metakeys;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $hits;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * Variable $this->new_image
     *
     * @var string
     */
    private $new_image;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categories", inversedBy="blogs")
     */
    private $category;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $language;
    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompte(): ?Compte
    {
        return $this->compte;
    }

    public function setCompte(?Compte $compte): self
    {
        $this->compte = $compte;

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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getPublish(): ?bool
    {
        return $this->publish;
    }

    public function setPublish(bool $publish): self
    {
        $this->publish = $publish;

        return $this;
    }

    public function getMetadesc(): ?string
    {
        return $this->metadesc;
    }

    public function setMetadesc(string $metadesc): self
    {
        $this->metadesc = $metadesc;

        return $this;
    }

    public function getMetakeys(): ?string
    {
        return $this->metakeys;
    }

    public function setMetakeys(string $metakeys): self
    {
        $this->metakeys = $metakeys;

        return $this;
    }

    public function getHits(): ?string
    {
        return $this->hits;
    }

    public function setHits(string $hits): self
    {
        $this->hits = $hits;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get the value of new_image
     * 
     * @return string
     */ 
    public function getNewImage(): ?string
    {
        return $this->new_image;
    }

    /**
     * Set the value of new_image
     * 
     * @param string $new_image comment 
     *
     * @return self
     */ 
    public function setNewImage(?string $new_image): self
    {
        $this->new_image = $new_image;

        return $this;
    }

    public function getCategory(): ?Categories
    {
        return $this->category;
    }

    public function setCategory(?Categories $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(string $language): self
    {
        $this->language = $language;

        return $this;
    }
}
