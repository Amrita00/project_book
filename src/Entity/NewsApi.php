<?php

namespace App\Entity;

use App\Repository\NewsApiRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=NewsApiRepository::class)
 * @ORM\Table(name="`news`")
 */
class NewsApi
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     *@ORM\Column(type="text")
     */
    private $author;

    /**
     *@ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     *@ORM\Column(type="text")
     */
    private $description;

    /**
     *@ORM\Column(type="string", length=255)
     */
    private $url;

    /**
     *@ORM\Column(type="string", length=255)
     *@Assert\File(mimeTypes={"image/png", "image/jpeg"})
     */
    private $urlToImage;

    /**
     * @ORM\Column(type="datetime")
     */
    private $publishedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function setAuthor($author)
    {
        $this->author = $author;
    }

    public function getTitle()
    {
        return $this->title;
    }


    public function setTitle($title)
    {
        $this->title = $title;
    }


    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }


    public function getUrl()
    {
        return $this->url;
    }


    public function setUrl($url)
    {
        $this->url = $url;
    }


    public function getUrlToImage()
    {
        return $this->urlToImage;
    }


    public function setUrlToImage($urlToImage)
    {
        $this->urlToImage = $urlToImage;
    }


    public function getPublishedAt()
    {
        return $this->publishedAt;
    }


    public function setPublishedAt($publishedAt)
    {
        $this->publishedAt = $publishedAt;
    }

}
