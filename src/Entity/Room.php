<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\RoomRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RoomRepository::class)
 */
#[ApiResource]
class Room
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
     * @ORM\Column(type="integer")
     */
    private $width;

    /**
     * @ORM\Column(type="integer")
     */
    private $length;

    /**
     * @ORM\OneToMany(targetEntity=Desk::class, mappedBy="room")
     */
    private $desks;

    public function __construct()
    {
        $this->desks = new ArrayCollection();
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

    public function getWidth(): ?int
    {
        return $this->width;
    }

    public function setWidth(int $width): self
    {
        $this->width = $width;

        return $this;
    }

    public function getLength(): ?int
    {
        return $this->length;
    }

    public function setLength(int $length): self
    {
        $this->length = $length;

        return $this;
    }

    /**
     * @return Collection<int, Desk>
     */
    public function getDesks(): Collection
    {
        return $this->desks;
    }

    public function addDesk(Desk $desk): self
    {
        if (!$this->desks->contains($desk)) {
            $this->desks[] = $desk;
            $desk->setRoom($this);
        }

        return $this;
    }

    public function removeDesk(Desk $desk): self
    {
        if ($this->desks->removeElement($desk)) {
            // set the owning side to null (unless already changed)
            if ($desk->getRoom() === $this) {
                $desk->setRoom(null);
            }
        }

        return $this;
    }
}
