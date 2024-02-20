<?php
// src/Entity/Carrito.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: "App\Repository\CarritoRepository")]
class Carrito
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=ItemCarrito::class, mappedBy="carrito", cascade={"persist", "remove"})
     */
    private $items;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|ItemCarrito[]
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(ItemCarrito $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items[] = $item;
            $item->setCarrito($this);
        }

        return $this;
    }

    public function removeItem(ItemCarrito $item): self
    {
        if ($this->items->removeElement($item)) {
            // set the owning side to null (unless already changed)
            if ($item->getCarrito() === $this) {
                $item->setCarrito(null);
            }
        }

        return $this;
    }
}
