<?php

namespace App\Entity;

use App\Repository\ThesaurusRepository;
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
}
