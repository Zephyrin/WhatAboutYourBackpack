<?php

namespace App\Entity;

use App\Repository\EquipmentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EquipmentRepository::class)
 */
class Equipment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=1024)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=1024, nullable=true)
     */
    private $uri;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="equipments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity=Brand::class, inversedBy="equipments")
     */
    private $brand;

    /**
     * @ORM\OneToMany(targetEntity=Characteristic::class, mappedBy="equipment", orphanRemoval=true)
     */
    private $characteristics;

    /**
     * @ORM\OneToMany(targetEntity=Possess::class, mappedBy="equipment", orphanRemoval=true)
     */
    private $possessedBy;

    /**
     * @ORM\OneToMany(targetEntity=Backpack::class, mappedBy="equipments")
     */
    private $backpacks;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="createdEquipment")
     * @ORM\JoinColumn(nullable=false)
     */
    private $createdBy;

    public function __construct()
    {
        $this->characteristics = new ArrayCollection();
        $this->possessedBy = new ArrayCollection();
        $this->backpacks = new ArrayCollection();
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

    public function getUri(): ?string
    {
        return $this->uri;
    }

    public function setUri(?string $uri): self
    {
        $this->uri = $uri;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    public function setBrand(?Brand $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * @return Collection|Characteristic[]
     */
    public function getCharacteristics(): Collection
    {
        return $this->characteristics;
    }

    public function addCharacteristic(Characteristic $characteristic): self
    {
        if (!$this->characteristics->contains($characteristic)) {
            $this->characteristics[] = $characteristic;
            $characteristic->setEquipment($this);
        }

        return $this;
    }

    public function removeCharacteristic(Characteristic $characteristic): self
    {
        if ($this->characteristics->contains($characteristic)) {
            $this->characteristics->removeElement($characteristic);
            // set the owning side to null (unless already changed)
            if ($characteristic->getEquipment() === $this) {
                $characteristic->setEquipment(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Possess[]
     */
    public function getPossessedBy(): Collection
    {
        return $this->possessedBy;
    }

    public function addPossessedBy(Possess $possessedBy): self
    {
        if (!$this->possessedBy->contains($possessedBy)) {
            $this->possessedBy[] = $possessedBy;
            $possessedBy->setEquipment($this);
        }

        return $this;
    }

    public function removePossessedBy(Possess $possessedBy): self
    {
        if ($this->possessedBy->contains($possessedBy)) {
            $this->possessedBy->removeElement($possessedBy);
            // set the owning side to null (unless already changed)
            if ($possessedBy->getEquipment() === $this) {
                $possessedBy->setEquipment(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Backpack[]
     */
    public function getBackpacks(): Collection
    {
        return $this->backpacks;
    }

    public function addBackpack(Backpack $backpack): self
    {
        if (!$this->backpacks->contains($backpack)) {
            $this->backpacks[] = $backpack;
            $backpack->setEquipments($this);
        }

        return $this;
    }

    public function removeBackpack(Backpack $backpack): self
    {
        if ($this->backpacks->contains($backpack)) {
            $this->backpacks->removeElement($backpack);
            // set the owning side to null (unless already changed)
            if ($backpack->getEquipments() === $this) {
                $backpack->setEquipments(null);
            }
        }

        return $this;
    }

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }
}
