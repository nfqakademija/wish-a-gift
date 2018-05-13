<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GiftRepository")
 */
class Gift
{
    /**
     * @var \Ramsey\Uuid\UuidInterface
     *
     * @ORM\Id()
     * @ORM\Column(type="uuid_binary", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $userId;

    /**
     * @ORM\Column(type="string")
     */
    private $title;

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
    private $giftList;

    /**
     * @return mixed
     */
    public function getGiftList()
    {
        return $this->giftList;
    }

    public function setGiftList(GiftList $giftList): self
    {
        $this->giftList = $giftList;

        return $this;
    }

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

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getReservedAt()
    {
        return $this->reservedAt;
    }

    /**
     * @param mixed $reservedAt
     */
    public function setReservedAt($reservedAt): void
    {
        $this->reservedAt = $reservedAt;
    }

    /**
     * @return mixed
     */
    public function getReservationToken()
    {
        return $this->reservationToken;
    }

    /**
     * @param mixed $reservationToken
     */
    public function setReservationToken($reservationToken): void
    {
        $this->reservationToken = $reservationToken;
    }


//    public function getGift(): ?string
//    {
//        return $this->gift;
//    }
//
//    public function setGift(string $gift): self
//    {
//        $this->gift = $gift;
//
//        return $this;
//    }
//
//    public function getActive(): ?int
//    {
//        return $this->active;
//    }
//
//    public function setActive(int $active): self
//    {
//        $this->active = $active;
//
//        return $this;
//    }


}