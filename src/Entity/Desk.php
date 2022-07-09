<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\DeskRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DeskRepository::class)
 * @ORM\Table(name="desk")
 */
#[ApiResource(
	itemOperations: [
               	'get',
               	'put' => [
               		'normalization_context' => ['groups' => ['put']],
               	],
               ],)]

class Desk
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=Room::class, inversedBy="desks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $room;

	/**
	 * @ORM\OneToMany(targetEntity=BookingLog::class, mappedBy="desk")
	 */
	private $bookingLogs;

	/**
     * @ORM\Column(type="integer")
     */
    private $x;

    /**
     * @ORM\Column(type="integer")
     */
    private $y;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $rotation;

    /**
     * @ORM\Column(type="integer")
     */
    private $width;

    /**
     * @ORM\Column(type="integer")
     */
    private $length;

    /**
     * @ORM\OneToMany(targetEntity=DeskFeatures::class, mappedBy="desk")
     */
    private $deskFeatures;

    public function __construct()
    {
		$this->bookingLogs = new ArrayCollection();
        $this->deskFeatures = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getRoom(): ?Room
    {
        return $this->room;
    }

    public function setRoom(?Room $room): self
    {
        $this->room = $room;

        return $this;
    }

    public function getX(): ?int
    {
        return $this->x;
    }

    public function setX(int $x): self
    {
        $this->x = $x;

        return $this;
    }

    public function getY(): ?int
    {
        return $this->y;
    }

    public function setY(int $y): self
    {
        $this->y = $y;

        return $this;
    }

    public function getRotation(): ?int
    {
        return $this->rotation;
    }

    public function setRotation(?int $rotation): self
    {
        $this->rotation = $rotation;

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
     * @return Collection<int, DeskFeatures>
     */
    public function getDeskFeatures(): Collection
    {
        return $this->deskFeatures;
    }

    public function addDeskFeature(DeskFeatures $deskFeature): self
    {
        if (!$this->deskFeatures->contains($deskFeature)) {
            $this->deskFeatures[] = $deskFeature;
            $deskFeature->setDesk($this);
        }

        return $this;
    }

    public function removeDeskFeature(DeskFeatures $deskFeature): self
    {
        if ($this->deskFeatures->removeElement($deskFeature)) {
            // set the owning side to null (unless already changed)
            if ($deskFeature->getDesk() === $this) {
                $deskFeature->setDesk(null);
            }
        }

        return $this;
    }
}
