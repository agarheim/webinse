<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UsersWRepository")
 */
class UsersW
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150)
     * @Assert\NotBlank
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $homePage;

    /**
     * @ORM\Column(type="string", length=150)
     * @Assert\NotBlank
     */
    private $email;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     */
    private $message;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateAdd;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\ImageUser", mappedBy="idUser", cascade={"persist", "remove"})
     */
    private $imageUser;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function gethomePage(): ?string
    {
        return $this->homePage;
    }

    public function sethomePage(string $homePage): self
    {
        $this->homePage = $homePage;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getDateAdd(): ?\DateTimeInterface
    {
        return $this->dateAdd;
    }

    public function setDateAdd(\DateTimeInterface $dateAdd): self
    {
        $this->dateAdd = $dateAdd;

        return $this;
    }

    public function getImageUser(): ?ImageUser
    {
        return $this->imageUser;
    }

    public function setImageUser(ImageUser $imageUser): self
    {
        $this->imageUser = $imageUser;

        // set the owning side of the relation if necessary
        if ($this !== $imageUser->getIdUser()) {
            $imageUser->setIdUser($this);
        }

        return $this;
    }
}
