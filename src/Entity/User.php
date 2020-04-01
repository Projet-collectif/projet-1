<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="boolean")
     */
    private $banned;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_active;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $usercrypt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $activation_key;

    /**
     * Undocumented variable
     *
     * @var string
     */
    private $new_password;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Compte", mappedBy="user", cascade={"persist", "remove"})
     */
    private $compte;

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
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
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getBanned(): ?bool
    {
        return $this->banned;
    }

    public function setBanned(bool $banned): self
    {
        $this->banned = $banned;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->is_active;
    }

    public function setIsActive(bool $is_active): self
    {
        $this->is_active = $is_active;

        return $this;
    }

    public function getUsercrypt(): ?string
    {
        return $this->usercrypt;
    }

    public function setUsercrypt(string $usercrypt): self
    {
        $this->usercrypt = $usercrypt;

        return $this;
    }

    public function getActivationKey(): ?string
    {
        return $this->activation_key;
    }

    public function setActivationKey(?string $activation_key): self
    {
        $this->activation_key = $activation_key;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return string
     */ 
    public function getNewPassword()
    {
        return $this->new_password;
    }

    /**
     * Set undocumented variable
     *
     * @param string $new_password Undocumented variable
     *
     * @return self
     */ 
    public function setNewPassword(string $new_password)
    {
        $this->new_password = $new_password;

        return $this;
    }

    public function getCompte(): ?Compte
    {
        return $this->compte;
    }

    public function setCompte(?Compte $compte): self
    {
        $this->compte = $compte;

        // set (or unset) the owning side of the relation if necessary
        $newUser = null === $compte ? null : $this;
        if ($compte->getUser() !== $newUser) {
            $compte->setUser($newUser);
        }

        return $this;
    }
}
