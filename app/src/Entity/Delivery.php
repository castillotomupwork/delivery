<?php

namespace App\Entity;

use App\Repository\DeliveryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DeliveryRepository::class)
 */
class Delivery
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="float")
     */
    private $total_weight;

    /**
     * @ORM\Column(type="float")
     */
    private $distance;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\OneToMany(targetEntity=ItemDelivery::class, mappedBy="delivery")
     */
    private $itemDeliveries;

    /**
     * @ORM\ManyToOne(targetEntity=Transport::class, inversedBy="deliveries")
     * @ORM\JoinColumn(nullable=false)
     */
    private $transport;

    public function __construct()
    {
        $this->itemDeliveries = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getTotalWeight(): ?float
    {
        return $this->total_weight;
    }

    public function setTotalWeight(float $total_weight): self
    {
        $this->total_weight = $total_weight;

        return $this;
    }

    public function getDistance(): ?float
    {
        return $this->distance;
    }

    public function setDistance(float $distance): self
    {
        $this->distance = $distance;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection|ItemDelivery[]
     */
    public function getItemDeliveries(): Collection
    {
        return $this->itemDeliveries;
    }

    public function addItemDelivery(ItemDelivery $itemDelivery): self
    {
        if (!$this->itemDeliveries->contains($itemDelivery)) {
            $this->itemDeliveries[] = $itemDelivery;
            $itemDelivery->setDelivery($this);
        }

        return $this;
    }

    public function removeItemDelivery(ItemDelivery $itemDelivery): self
    {
        if ($this->itemDeliveries->removeElement($itemDelivery)) {
            // set the owning side to null (unless already changed)
            if ($itemDelivery->getDelivery() === $this) {
                $itemDelivery->setDelivery(null);
            }
        }

        return $this;
    }

    public function getTransport(): ?Transport
    {
        return $this->transport;
    }

    public function setTransport(?Transport $transport): self
    {
        $this->transport = $transport;

        return $this;
    }
}
