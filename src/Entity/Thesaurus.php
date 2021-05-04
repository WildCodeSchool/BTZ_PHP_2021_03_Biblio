<?php

namespace App\Entity;

use App\Repository\ThesaurusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ThesaurusRepository::class)
 */
class Thesaurus
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $ancestor_id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $theme;

    /**
     * @ORM\OneToMany(targetEntity=Thematic::class, mappedBy="Thesaurus")
     */
    private $thematics;

    public function __construct()
    {
        $this->thematics = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAncestorId(): ?int
    {
        return $this->ancestor_id;
    }

    public function setAncestorId(?int $ancestor_id): self
    {
        $this->ancestor_id = $ancestor_id;

        return $this;
    }

    public function getTheme(): ?string
    {
        return $this->theme;
    }

    public function setTheme(?string $theme): self
    {
        $this->theme = $theme;

        return $this;
    }

    /**
     * @return Collection|Thematic[]
     */
    public function getThematics(): Collection
    {
        return $this->thematics;
    }

    public function addThematic(Thematic $thematic): self
    {
        if (!$this->thematics->contains($thematic)) {
            $this->thematics[] = $thematic;
            $thematic->setThesaurus($this);
        }

        return $this;
    }

    public function removeThematic(Thematic $thematic): self
    {
        if ($this->thematics->removeElement($thematic)) {
            // set the owning side to null (unless already changed)
            if ($thematic->getThesaurus() === $this) {
                $thematic->setThesaurus(null);
            }
        }

        return $this;
    }
}
