<?php

namespace App\Entity;

use App\Repository\TransportRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TransportRepository::class)
 */
class Transport
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(type="float")
     */
    private $weight_limit;

    /**
     * @ORM\Column(type="integer")
     */
    private $distance_limit;

    /**
     * @ORM\Column(type="float")
     */
    private $distance_price;

    /**
     * @ORM\OneToMany(targetEntity=Delivery::class, mappedBy="transport")
     */
    private $deliveries;

    public function __construct()
    {
        $this->deliveries = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getWeightLimit(): ?float
    {
        return $this->weight_limit;
    }

    public function setWeightLimit(float $weight_limit): self
    {
        $this->weight_limit = $weight_limit;

        return $this;
    }

    public function getDistanceLimit(): ?int
    {
        return $this->distance_limit;
    }

    public function setDistanceLimit(int $distance_limit): self
    {
        $this->distance_limit = $distance_limit;

        return $this;
    }

    public function getDistancePrice(): ?float
    {
        return $this->distance_price;
    }

    public function setDistancePrice(float $distance_price): self
    {
        $this->distance_price = $distance_price;

        return $this;
    }

    /**
     * @return Collection|Delivery[]
     */
    public function getDeliveries(): Collection
    {
        return $this->deliveries;
    }

    public function addDelivery(Delivery $delivery): self
    {
        if (!$this->deliveries->contains($delivery)) {
            $this->deliveries[] = $delivery;
            $delivery->setTransport($this);
        }

        return $this;
    }

    public function removeDelivery(Delivery $delivery): self
    {
        if ($this->deliveries->removeElement($delivery)) {
            // set the owning side to null (unless already changed)
            if ($delivery->getTransport() === $this) {
                $delivery->setTransport(null);
            }
        }

        return $this;
    }
}
