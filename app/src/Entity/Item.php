<?php

namespace App\Entity;

use App\Repository\ItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ItemRepository::class)
 */
class Item
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
    private $min_weight;

    /**
     * @ORM\Column(type="float")
     */
    private $max_weight;

    /**
     * @ORM\OneToMany(targetEntity=ItemDelivery::class, mappedBy="item")
     */
    private $itemDeliveries;

    public function __construct()
    {
        $this->itemDeliveries = new ArrayCollection();
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

    public function getMinWeight(): ?float
    {
        return $this->min_weight;
    }

    public function setMinWeight(float $min_weight): self
    {
        $this->min_weight = $min_weight;

        return $this;
    }

    public function getMaxWeight(): ?float
    {
        return $this->max_weight;
    }

    public function setMaxWeight(float $max_weight): self
    {
        $this->max_weight = $max_weight;

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
            $itemDelivery->setItem($this);
        }

        return $this;
    }

    public function removeItemDelivery(ItemDelivery $itemDelivery): self
    {
        if ($this->itemDeliveries->removeElement($itemDelivery)) {
            // set the owning side to null (unless already changed)
            if ($itemDelivery->getItem() === $this) {
                $itemDelivery->setItem(null);
            }
        }

        return $this;
    }
}
