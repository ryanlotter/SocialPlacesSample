<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContactRepository")
 */
class Contact
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()(
     *     checkMX = true
     * )
     */
    private $Name;

    /**
     * @ORM\Column(type="string", length=200)
     * @Assert\NotBlank()(
     *     checkMX = true
     * )
     */
    private $Surname;

    /**
     * @ORM\Column(type="string", length=20)
     * @Assert\NotBlank()(
     *     checkMX = true
     * )
     */
    private $PhoneNumber;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email.",
     *     checkMX = true
     * )
     */
    private $EmailAdress;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->Surname;
    }

    public function setSurname(string $Surname): self
    {
        $this->Surname = $Surname;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->PhoneNumber;
    }

    public function setPhoneNumber(string $PhoneNumber): self
    {
        $this->PhoneNumber = $PhoneNumber;

        return $this;
    }

    public function getEmailAdress(): ?string
    {
        return $this->EmailAdress;
    }

    public function setEmailAdress(string $EmailAdress): self
    {
        $this->EmailAdress = $EmailAdress;

        return $this;
    }
}
