<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GiftListRepository")
 * @ORM\Table(name="gift_list")
 */
class GiftList
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="GUID")
     * @ORM\Column(type="guid")
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
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $uuid;
    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $uuidadmin;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Gift", mappedBy="giftList")
//     * @ORM\JoinColumn(name="gift_list_id", referencedColumnName="id")
     */
    protected $gifts;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;


    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->gifts = new ArrayCollection();
    }


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

    public function getGifts(): ArrayCollection
    {
        return $this->gifts;
    }

    public function addGift(Gift $gift): void
    {
        if (!$this->gifts->contains($gift)) {
            $this->gifts->add($gift);
        }
    }

    public function removeGift(Gift $gift): void
    {
        if ($this->gifts->contains($gift)) {
            $this->gifts->removeElement($gift);
        }
    }
}
