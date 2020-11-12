<?php

namespace App\Entity;

use App\Repository\CharacteristicRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CharacteristicRepository::class)
 */
class Characteristic
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=512)
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity=Equipment::class, inversedBy="characteristics")
     * @ORM\JoinColumn(nullable=false)
     */
    private $equipment;

    /**
     * @ORM\ManyToOne(targetEntity=Characteristic::class, inversedBy="characteristic")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity=Characteristic::class, mappedBy="parent")
     */
    private $characteristic;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $unit;

    public function __construct()
    {
        $this->characteristic = new ArrayCollection();
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

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getEquipment(): ?Equipment
    {
        return $this->equipment;
    }

    public function setEquipment(?Equipment $equipment): self
    {
        $this->equipment = $equipment;

        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getCharacteristic(): Collection
    {
        return $this->characteristic;
    }

    public function addCharacteristic(self $characteristic): self
    {
        if (!$this->characteristic->contains($characteristic)) {
            $this->characteristic[] = $characteristic;
            $characteristic->setParent($this);
        }

        return $this;
    }

    public function removeCharacteristic(self $characteristic): self
    {
        if ($this->characteristic->contains($characteristic)) {
            $this->characteristic->removeElement($characteristic);
            // set the owning side to null (unless already changed)
            if ($characteristic->getParent() === $this) {
                $characteristic->setParent(null);
            }
        }

        return $this;
    }

    public function getUnit(): ?string
    {
        return $this->unit;
    }

    public function setUnit(?string $unit): self
    {
        $this->unit = $unit;

        return $this;
    }
}
