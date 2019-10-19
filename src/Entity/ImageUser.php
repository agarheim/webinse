<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
/**
 * @ORM\Entity(repositoryClass="App\Repository\ImageUserRepository")
 * @Vich\Uploadable()
 */
class ImageUser
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $imageName;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\UsersW", inversedBy="imageUser", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $idUser;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mimeType;

    /**
     * @var File
     *
     * @Vich\UploadableField(mapping="users", fileNameProperty="imageName", originalName="originalName", mimeType="mimeType")
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $originalName;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(string $imageName): self
    {
        $this->imageName = $imageName;

        return $this;
    }

    public function getIdUser(): ?UsersW
    {
        return $this->idUser;
    }

    public function setIdUser(UsersW $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }

    public function getMimeType(): ?string
    {
        return $this->mimeType;
    }

    public function setMimeType(string $mimeType): self
    {
        $this->mimeType = $mimeType;

        return $this;
    }

    public function getOriginalName(): ?string
    {
        return $this->originalName;
    }

    public function setOriginalName(string $originalName): self
    {
        $this->originalName = $originalName;

        return $this;
    }
}
