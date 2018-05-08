<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GiftRepository")
 */
class Gift
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="GUID")
     * @ORM\Column(type="guid")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $userId;

    /**
     * @ORM\Column(type="string")
     */
    private $title;

    /**
     * @ORM\Column(type="string")
     */
    private $description;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $reservedAt;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $reservationToken;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\GiftList", inversedBy="gifts")
     * @ORM\JoinColumn(name="gift_list_id", referencedColumnName="id", nullable=false)
     */
    private $giftListId;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getGift(): ?string
    {
        return $this->gift;
    }

    public function setGift(string $gift): self
    {
        $this->gift = $gift;

        return $this;
    }

    public function getActive(): ?int
    {
        return $this->active;
    }

    public function setActive(int $active): self
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getGiftListId()
    {
        return $this->giftListId;
    }

    /**
     * @param mixed $giftListId
     * @return self
     */
    public function setGiftListId($giftListId): self
    {
        $this->giftListId = $giftListId;

        return $this;
    }
}