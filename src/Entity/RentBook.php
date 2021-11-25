<?php

namespace App\Entity;

use App\Repository\RentBookRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RentBookRepository::class)
 */
class RentBook
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
    private ?\DateTimeInterface $rent_date;

    /**
     * @ORM\Column(type="date")
     */
    private ?\DateTimeInterface $return_date;

    /**
     * @ORM\ManyToOne(targetEntity=Book::class, inversedBy="rentBooks")
     */
    private ?Book $book_id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="rentBooks")
     */
    private ?User $user_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRentDate(): ?\DateTimeInterface
    {
        return $this->rent_date;
    }

    public function setRentDate(\DateTimeInterface $rent_date): self
    {
        $this->rent_date = $rent_date;

        return $this;
    }

    public function getReturnDate(): ?\DateTimeInterface
    {
        return $this->return_date;
    }

    public function setReturnDate(\DateTimeInterface $return_date): self
    {
        $this->return_date = $return_date;

        return $this;
    }

    public function getBook(): ?Book
    {
        return $this->book_id;
    }

    public function setBook(?Book $book_id): self
    {
        $this->book_id = $book_id;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user_id;
    }

    public function setUser(?User $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }
}
