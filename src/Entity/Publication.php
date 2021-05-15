<?php

namespace App\Entity;

use App\Repository\PublicationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PublicationRepository::class)
 */
class Publication
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mention;

    /**
     * @ORM\Column(type="datetime")
     */
    private $publication_date;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $paging;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $volume_number;

    /**
     * @ORM\Column(type="text")
     */
    private $summary;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $issn_isbn;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $support;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $source_address;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cote;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $access;

    /**
     * @ORM\ManyToOne(targetEntity=PublicationType::class, inversedBy="publications")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=Localisation::class, inversedBy="publications")
     */
    private $localisation;

    /**
     * @ORM\ManyToOne(targetEntity=Thematic::class, inversedBy="publications")
     * @ORM\JoinColumn(nullable=false)
     */
    private $thematic;

    /**
     * @ORM\ManyToOne(targetEntity=Language::class, inversedBy="publications")
     * @ORM\JoinColumn(nullable=false)
     */
    private $language;

    /**
     * @ORM\ManyToMany(targetEntity=Editor::class, inversedBy="publications")
     */
    private $editors;

    /**
     * @ORM\ManyToOne(targetEntity=BookCollection::class, inversedBy="publications")
     */
    private $bookcollection;

    /**
     * @ORM\ManyToMany(targetEntity=Author::class, inversedBy="publications")
     */
    private $authors;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\OneToMany(targetEntity=Keyword::class, mappedBy="publication")
     */
    private $keywords;

    /**
     * @ORM\OneToMany(targetEntity=Borrow::class, mappedBy="publication")
     */
    private $borrows;

    /**
     * @ORM\ManyToMany(targetEntity=KeywordRef::class, mappedBy="publication")
     */
    private $keywordRefs;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $update_date;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="publications")
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity=KeywordGeo::class, mappedBy="publications")
     */
    private $keywordGeos;

    public function __construct()
    {
        $this->editors = new ArrayCollection();
        $this->authors = new ArrayCollection();
        $this->keywordRefs = new ArrayCollection();
        $this->keywordGeos = new ArrayCollection();
        $this->borrows = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getMention(): ?string
    {
        return $this->mention;
    }

    public function setMention(string $mention): self
    {
        $this->mention = $mention;

        return $this;
    }

    public function getPublicationDate(): ?\DateTimeInterface
    {
        return $this->publication_date;
    }

    public function setPublicationDate(\DateTimeInterface $publication_date): self
    {
        $this->publication_date = $publication_date;

        return $this;
    }

    public function getPaging(): ?int
    {
        return $this->paging;
    }

    public function setPaging(int $paging): self
    {
        $this->paging = $paging;

        return $this;
    }

    public function getVolumeNumber(): ?string
    {
        return $this->volume_number;
    }

    public function setVolumeNumber(?string $volume_number): self
    {
        $this->volume_number = $volume_number;

        return $this;
    }

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(?string $summary): self
    {
        $this->summary = $summary;

        return $this;
    }

    public function getIssnIsbn(): ?string
    {
        return $this->issn_isbn;
    }

    public function setIssnIsbn(string $issn_isbn): self
    {
        $this->issn_isbn = $issn_isbn;

        return $this;
    }

    public function getSupport(): ?string
    {
        return $this->support;
    }

    public function setSupport(string $support): self
    {
        $this->support = $support;

        return $this;
    }

    public function getSourceAddress(): ?string
    {
        return $this->source_address;
    }

    public function setSourceAddress(?string $source_address): self
    {
        $this->source_address = $source_address;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getCote(): ?string
    {
        return $this->cote;
    }

    public function setCote(string $cote): self
    {
        $this->cote = $cote;

        return $this;
    }

    public function getAccess(): ?string
    {
        return $this->access;
    }

    public function setAccess(string $access): self
    {
        $this->access = $access;

        return $this;
    }

    public function getType(): ?PublicationType
    {
        return $this->type;
    }

    public function setType(?PublicationType $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getLocalisation(): ?Localisation
    {
        return $this->localisation;
    }

    public function setLocalisation(?Localisation $localisation): self
    {
        $this->localisation = $localisation;

        return $this;
    }

    public function getThematic(): ?Thematic
    {
        return $this->thematic;
    }

    public function setThematic(?Thematic $thematic): self
    {
        $this->thematic = $thematic;

        return $this;
    }

    public function getLanguage(): ?Language
    {
        return $this->language;
    }

    public function setLanguage(?Language $language): self
    {
        $this->language = $language;

        return $this;
    }

    /**
     * @return Collection|Editor[]
     */
    public function getEditors(): Collection
    {
        return $this->editors;
    }

    public function addEditor(Editor $editor): self
    {
        if (!$this->editors->contains($editor)) {
            $this->editors[] = $editor;
        }

        return $this;
    }

    public function removeEditor(Editor $editor): self
    {
        $this->editors->removeElement($editor);

        return $this;
    }

    public function getBookcollection(): ?BookCollection
    {
        return $this->bookcollection;
    }

    public function setBookcollection(?BookCollection $bookcollection): self
    {
        $this->bookcollection = $bookcollection;

        return $this;
    }

    /**
     * @return Collection|Author[]
     */
    public function getAuthors(): Collection
    {
        return $this->authors;
    }

    public function addAuthor(Author $author): self
    {
        if (!$this->authors->contains($author)) {
            $this->authors[] = $author;
        }

        return $this;
    }

    public function removeAuthor(Author $author): self
    {
        $this->authors->removeElement($author);

        return $this;
    }

    /**
     * @return Collection|Keyword[]
     */
    public function getKeywords(): Collection
    {
        return $this->keywords;
    }

    public function addKeyword(Keyword $keyword): self
    {
        if (!$this->keywords->contains($keyword)) {
            $this->keywords[] = $keyword;
            $keyword->setPublication($this);
        }

        return $this;
    }

    public function removeKeyword(Keyword $keyword): self
    {
        if ($this->keywords->removeElement($keyword)) {
            // set the owning side to null (unless already changed)
            if ($keyword->getPublication() === $this) {
                $keyword->setPublication(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Borrow[]
     */
    public function getBorrows(): Collection
    {
        return $this->borrows;
    }

    public function addBorrow(Borrow $borrow): self
    {
        if (!$this->borrows->contains($borrow)) {
            $this->borrows[] = $borrow;
            $borrow->setPublication($this);
        }

        return $this;
    }

    public function removeBorrow(Borrow $borrow): self
    {
        if ($this->borrows->removeElement($borrow)) {
            // set the owning side to null (unless already changed)
            if ($borrow->getPublication() === $this) {
                $borrow->setPublication(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): void
    {
        $this->user = $user;
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
     * @return Collection|KeywordRef[]
     */
    public function getKeywordRefs(): Collection
    {
        return $this->keywordRefs;
    }

    public function addKeywordRef(KeywordRef $keywordRef): self
    {
        if (!$this->keywordRefs->contains($keywordRef)) {
            $this->keywordRefs[] = $keywordRef;
            $keywordRef->addPublication($this);
        }

        return $this;
    }

    public function removeKeywordRef(KeywordRef $keywordRef): self
    {
        if ($this->keywordRefs->removeElement($keywordRef)) {
            $keywordRef->removePublication($this);
        }

        return $this;
    }

    public function getUpdateDate(): ?\DateTimeInterface
    {
        return $this->update_date;
    }

    public function setUpdateDate(?\DateTimeInterface $update_date): self
    {
        $this->update_date = $update_date;

        return $this;
    }

    /**
     * @return Collection|KeywordGeo[]
     */
    public function getKeywordGeos(): Collection
    {
        return $this->keywordGeos;
    }

    public function addKeywordGeo(KeywordGeo $keywordGeo): self
    {
        if (!$this->keywordGeos->contains($keywordGeo)) {
            $this->keywordGeos[] = $keywordGeo;
            $keywordGeo->addPublication($this);
        }

        return $this;
    }

    public function removeKeywordGeo(KeywordGeo $keywordGeo): self
    {
        if ($this->keywordGeos->removeElement($keywordGeo)) {
            $keywordGeo->removePublication($this);
        }

        return $this;
    }
}
