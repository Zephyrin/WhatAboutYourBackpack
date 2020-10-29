<?php

namespace App\Entity;

use App\Enum\GenderEnum;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use DateTime;
use Symfony\Component\Security\Core\User\UserInterface;
use JMS\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Asset;
use JMS\Serializer\Annotation\Exclude;
use Swagger\Annotations as SWG;
use InvalidArgumentException;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
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
    private $username;

    /**
     * @ORM\OneToMany(targetEntity=Possess::class, mappedBy="user", orphanRemoval=true)
     */
    private $possesses;

    /**
     * @ORM\OneToMany(targetEntity=Backpack::class, mappedBy="user", orphanRemoval=true)
     */
    private $backpacks;

    /**
     * @ORM\OneToMany(targetEntity=Equipment::class, mappedBy="createdBy")
     */
    private $createdEquipment;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @Exclude
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=6, nullable=false )
     * @SerializedName("gender")
     * @Asset\NotBlank()
     * @SWG\Property(
     *     description="The gender of the user."
     *     , enum={GenderEnum::MALE, GenderEnum::FEMALE})
     * @var string
     */
    protected $gender;

    /**
     * @ORM\Column(type="string", length=255)
     * @Asset\NotBlank()
     */
    private $email;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @SerializedName("lastLogin")
     * @SWG\Property(
     *  description="The last login of user")
     * @var DateTime
     */
    private $lastLogin;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @SerializedName("created")
     * @SWG\Property(
     *  description="The date when the user was created")
     * @var DateTime
     */
    private $created;

    public function __construct()
    {
        $this->possesses = new ArrayCollection();
        $this->backpacks = new ArrayCollection();
        $this->createdEquipment = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return Collection|Possess[]
     */
    public function getPossesses(): Collection
    {
        return $this->possesses;
    }

    public function addPossess(Possess $possess): self
    {
        if (!$this->possesses->contains($possess)) {
            $this->possesses[] = $possess;
            $possess->setUser($this);
        }

        return $this;
    }

    public function removePossess(Possess $possess): self
    {
        if ($this->possesses->contains($possess)) {
            $this->possesses->removeElement($possess);
            // set the owning side to null (unless already changed)
            if ($possess->getUser() === $this) {
                $possess->setUser(null);
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
            $backpack->setUser($this);
        }

        return $this;
    }

    public function removeBackpack(Backpack $backpack): self
    {
        if ($this->backpacks->contains($backpack)) {
            $this->backpacks->removeElement($backpack);
            // set the owning side to null (unless already changed)
            if ($backpack->getUser() === $this) {
                $backpack->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Equipment[]
     */
    public function getCreatedEquipment(): Collection
    {
        return $this->createdEquipment;
    }

    public function addCreatedEquipment(Equipment $createdEquipment): self
    {
        if (!$this->createdEquipment->contains($createdEquipment)) {
            $this->createdEquipment[] = $createdEquipment;
            $createdEquipment->setCreatedBy($this);
        }

        return $this;
    }

    public function removeCreatedEquipment(Equipment $createdEquipment): self
    {
        if ($this->createdEquipment->contains($createdEquipment)) {
            $this->createdEquipment->removeElement($createdEquipment);
            // set the owning side to null (unless already changed)
            if ($createdEquipment->getCreatedBy() === $this) {
                $createdEquipment->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        if (!in_array($gender, GenderEnum::getAvailableTypes())) {
            throw new InvalidArgumentException("Invalid type");
        }
        $this->gender = $gender;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getLastLogin(): ?DateTime
    {
        return $this->lastLogin;
    }

    public function setLastLogin(DateTime $lastLogin): self
    {
        $this->lastLogin = $lastLogin;
        return $this;
    }

    public function getCreated(): ?DateTime
    {
        return $this->created;
    }

    public function setCreated(DateTime $created): self
    {
        $this->created = $created;
        return $this;
    }
}
