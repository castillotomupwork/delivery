<?php

namespace App\Entity;

use App\Repository\ItemDeliveryRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ItemDeliveryRepository::class)
 */
class ItemDelivery
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Item::class, inversedBy="itemDeliveries")
     * @ORM\JoinColumn(nullable=false)
     */
    private $item;

    /**
     * @ORM\ManyToOne(targetEntity=Delivery::class, inversedBy="itemDeliveries")
     * @ORM\JoinColumn(nullable=false)
     */
    private $delivery;

    /**
     * @ORM\Column(type="float")
     */
    private $weight;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getItem(): ?Item
    {
        return $this->item;
    }

    public function setItem(?Item $item): self
    {
        $this->item = $item;

        return $this;
    }

    public function getDelivery(): ?Delivery
    {
        return $this->delivery;
    }

    public function setDelivery(?Delivery $delivery): self
    {
        $this->delivery = $delivery;

        return $this;
    }

    public function getWeight(): ?float
    {
        return $this->weight;
    }

    public function setWeight(float $weight): self
    {
        $this->weight = $weight;

        return $this;
    }
}
