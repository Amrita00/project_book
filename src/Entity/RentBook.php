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
    private $rent_book;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRentBook(): ?\DateTimeInterface
    {
        return $this->rent_book;
    }

    public function setRentBook(\DateTimeInterface $rent_book): self
    {
        $this->rent_book = $rent_book;

        return $this;
    }
}
