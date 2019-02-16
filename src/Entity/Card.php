<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CardRepository")
 */
class Card
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @Groups({"userAdmin", "card"})
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"user","userAdmin", "card"})
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @Groups({"userAdmin", "card"})
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $creditCardType;

    /**
     * @Groups({"userAdmin", "card"})
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $creditCardNumber;

    /**
     * @Groups({"userAdmin", "card"})
     * @ORM\Column(type="string", length=255)
     * @Assert\Currency
     */
    private $currencyCode;

    /**
     * @Groups({"userAdmin", "card"})
     * @ORM\Column(type="float")
     * @Assert\All({
     *   @Assert\NotBlank,
     *   @Assert\Range(
     *    min = 0,
     *    max = 100000,
     *    minMessage = "You can't have a negative sold",
     *    maxMessage = "You can't have more than {{ limit }}. Please create a new card"
     *    )
     * })
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="cards")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"card"})
     * @Assert\Valid
     */
    private $user;

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

    public function getCreditCardType(): ?string
    {
        return $this->creditCardType;
    }

    public function setCreditCardType(string $creditCardType): self
    {
        $this->creditCardType = $creditCardType;

        return $this;
    }

    public function getCreditCardNumber(): ?string
    {
        return $this->creditCardNumber;
    }

    public function setCreditCardNumber(string $creditCardNumber): self
    {
        $this->creditCardNumber = $creditCardNumber;

        return $this;
    }

    public function getCurrencyCode(): ?string
    {
        return $this->currencyCode;
    }

    public function setCurrencyCode(string $currencyCode): self
    {
        $this->currencyCode = $currencyCode;

        return $this;
    }

    public function getValue(): ?float
    {
        return $this->value;
    }

    public function setValue(float $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
