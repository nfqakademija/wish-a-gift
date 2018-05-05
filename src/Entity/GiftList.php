<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GiftListRepository")
 * @ORM\Table(indexes={@ORM\Index(columns={"uuid", "uuidadmin"})})
 */
class GiftList
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=101)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=101)
     */
    private $email;
    /**
     * @ORM\Column(type="string", length=200)
     */
    private $title;
    /**
     * @ORM\Column(type="text")
     */
    private $description;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $uuid;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $uuidadmin;

    protected $gift;


    public function getId()
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function getUuidAdmin(): ?string
    {
        return $this->uuidadmin;
    }

    public function setUuidAdmin(string $uuidadmin): self
    {
        $this->uuidadmin = $uuidadmin;

        return $this;
    }

    public function getGift()
    {
        return $this->gift;
    }

    public function setGift(Gift $gift = null)
    {
        $this->gift= $gift;
    }
}
