<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass=BookRepository::class)
 * @ORM\Table(name="`book`")
 * @UniqueEntity(fields={"name"}, message="This book already exists")
 */
class Book
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Please, enter title.")
     */
    private ?string $name;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Please, enter description.")
     */
    private ?string $description;

    /**
     *@ORM\Column(type="string", length=255)
     *@Assert\NotBlank(message="Please, enter author name")
     */
    private $author;

    /** @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Please, enter the price")
     * @Assert\GreaterThan(value=0)
     * @Assert\Regex(pattern="/^[1-9]+[0-9]*$")
     *
     */
    private $price;
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Please, upload the photo.")
     * @Assert\File(mimeTypes={ "image/png", "image/jpeg" })
     */
    private $image;

    /**
     * @ORM\OneToMany(targetEntity=RentBook::class, mappedBy="book")
     */
    private Collection $rentBooks;

    public function __construct()
    {
        $this->rentBooks = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;

    }


    public function getAuthor()
    {
        return $this->author;
    }


    public function setAuthor($author): void
    {
        $this->author = $author;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description)
    {
        $this->description = $description;

    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price): void
    {
        $this->price = $price;
    }


    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return Collection|RentBook[]
     */
    public function getRentBooks(): Collection
    {
        return $this->rentBooks;
    }

    public function addRentBook(RentBook $rentBook): self
    {
        if (!$this->rentBooks->contains($rentBook)) {
            $this->rentBooks[] = $rentBook;
            $rentBook->setBook($this);
        }

        return $this;
    }

    public function removeRentBook(RentBook $rentBook): self
    {
        if ($this->rentBooks->removeElement($rentBook)) {
            // set the owning side to null (unless already changed)
            if ($rentBook->getBook() === $this) {
                $rentBook->setBook(null);
            }
        }

        return $this;
    }

}
