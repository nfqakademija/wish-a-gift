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
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $userId;

    /**
     * @ORM\Column(type="string", length=254)
     */
    private $gift;

    /**
     * @ORM\Column(type="smallint", options={"default" : 1})
     */
    private $active;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\GiftList", inversedBy="gifts")
     * @ORM\JoinColumn(name="gift_list_id", referencedColumnName="id")
     */
    protected $giftList;


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