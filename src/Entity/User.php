<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @method string getUserIdentifier()
 */
#[ApiResource(
    collectionOperations: ['get' => ['normalization_context' => ['groups' => 'user:list']]],
//    itemOperations: ['get' => ['normalization_context' => ['groups' => 'user:item']]],
    paginationEnabled: true,
)]
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $login;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $first_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $last_name;

    /**
     * @ORM\OneToMany(targetEntity=BookingLog::class, mappedBy="user")
     */
    private $bookingLogs;

    public function __construct()
    {
        $this->bookingLogs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): self
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): self
    {
        $this->last_name = $last_name;

        return $this;
    }

    /**
     * @return Collection<int, BookingLog>
     */
    public function getBookingLogs(): Collection
    {
        return $this->bookingLogs;
    }

    public function addBookingLog(BookingLog $bookingLog): self
    {
        if (!$this->bookingLogs->contains($bookingLog)) {
            $this->bookingLogs[] = $bookingLog;
            $bookingLog->setUser($this);
        }

        return $this;
    }

    public function removeBookingLog(BookingLog $bookingLog): self
    {
        if ($this->bookingLogs->removeElement($bookingLog)) {
            // set the owning side to null (unless already changed)
            if ($bookingLog->getUser() === $this) {
                $bookingLog->setUser(null);
            }
        }

        return $this;
    }

	public function getRoles()
	{
		return ['ROLE_USER'];
	}

	public function getPassword()
	{
		return 'pass';
	}

	public function getSalt()
	{
		// TODO: Implement getSalt() method.
	}

	public function eraseCredentials()
	{
		// TODO: Implement eraseCredentials() method.
	}

	public function getUsername()
	{
		return $this->login;
	}
}
