<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GiftListRepository")
 * @ORM\Table(name="gift_list")
 */
class GiftList
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="guid")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=101)
     */
    private $firstName;

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
    private $uuidAdmin;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Gift", mappedBy="giftList", cascade={"all"})
     */
    private $gifts;

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

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

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
        return $this->uuidAdmin;
    }

    public function setUuidAdmin(string $uuidAdmin): self
    {
        $this->uuidAdmin = $uuidAdmin;

        return $this;
    }

    public function getGifts(): Collection
    {
        return $this->gifts;
    }

    public function addGift(Gift $gift): void
    {
        if (!$this->gifts->contains($gift)) {
            $this->gifts->add($gift);
            $gift->setGiftList($this);
        }
    }

    public function removeGift(Gift $gift): void
    {
        if ($this->gifts->contains($gift)) {
            $this->gifts->removeElement($gift);
            $gift->setGiftList(null);
        }
    }
}
