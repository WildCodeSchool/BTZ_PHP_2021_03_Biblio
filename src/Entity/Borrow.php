<?php

namespace App\Entity;

use App\Repository\BorrowRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BorrowRepository::class)
 */
class Borrow
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $reservation_date;

    /**
     * @ORM\Column(type="date")
     */
    private $borrowed_date;

    /**
     * @ORM\Column(type="date")
     */
    private $limit_date;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $comment;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="borrow")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Publication::class, inversedBy="borrow")
     */
    private $publication;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReservationDate(): ?\DateTimeInterface
    {
        return $this->reservation_date;
    }

    public function setReservationDate(\DateTimeInterface $reservation_date): self
    {
        $this->reservation_date = $reservation_date;

        return $this;
    }

    public function getBorrowedDate(): ?\DateTimeInterface
    {
        return $this->borrowed_date;
    }

    public function setBorrowedDate(\DateTimeInterface $borrowed_date): self
    {
        $this->borrowed_date = $borrowed_date;

        return $this;
    }

    public function getLimitDate(): ?\DateTimeInterface
    {
        return $this->limit_date;
    }

    public function setLimitDate(\DateTimeInterface $limit_date): self
    {
        $this->limit_date = $limit_date;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getPublication(): ?Publication
    {
        return $this->publication;
    }

    public function setPublication(?Publication $publication): self
    {
        $this->publication = $publication;

        return $this;
    }
    public function __toString()
    {
        return $this->user->getFullname();
    }
}