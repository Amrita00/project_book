<?php

namespace App\Entity;

use App\Repository\BookRepository;
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
    private $name;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Please, enter description.")
     */
    private $description;

    /**
     *@ORM\Column(type="string", length=255)
     *@Assert\NotBlank(message="Please, enter author name")
     */
    private $author;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Please, upload the photo.")
     * @Assert\File(mimeTypes={ "image/png", "image/jpeg" })
     */
    private $image;

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


    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }



}
