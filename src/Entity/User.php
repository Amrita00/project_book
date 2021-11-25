<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 * @UniqueEntity(fields={"username"}, message="There is already an account with this username")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Firstname should not be empty")
     */
    private $firstname;


    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Lastname should not be empty")
     */
    private $lastname;


    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank(message="Username should not be empty")
     */
    private string $username;


    /**
     * @ORM\Column(type="json")
     */
    private array $roles = [];


    /**
     * @var string The hashed password
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Password should not be empty")
     */
    private string $password;

    /**
     * @ORM\OneToMany(targetEntity=RentBook::class, mappedBy="user")
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

    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param mixed $firstname
     */
    public function setFirstname($firstname): void
    {
        $this->firstname = $firstname;
    }

    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param mixed $lastname
     */
    public function setLastname($lastname): void
    {
        $this->lastname = $lastname;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string)$this->username;
    }

    public function setUsername(?string $username): void
    {
        $this->username = $username;

    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string)$this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        if(empty($roles))
        {
            $roles[] = 'ROLE_USER';
        }
        return array_unique($roles);
    }

    public function setRoles(array $roles): void
    {
        $this->roles = $roles;

    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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
            $rentBook->setUser($this);
        }

        return $this;
    }

    public function removeRentBook(RentBook $rentBook): self
    {
        if ($this->rentBooks->removeElement($rentBook)) {
            // set the owning side to null (unless already changed)
            if ($rentBook->getUser() === $this) {
                $rentBook->setUser(null);
            }
        }

        return $this;
    }

}
