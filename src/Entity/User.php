<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Table(name="app_user")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class User implements UserInterface, \Serializable
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
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Role", inversedBy="users")
     */
    private $role;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $username;

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
        return (string) $this->username;
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

    public function getUser(): ?role
    {
        return $this->user;
    }

    public function setUser(?role $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getRoles(): array // fonction necessaire pour security.yml => ceci n'est pas un getter en relation avec ma BDD
    {
        $roles = [];      
  
        if(!is_null($this->role)){
            $roles[] = $this->role->getCode(); // ici on stockera le code associé dans la BDD dans le genre ROLE_USER, ROLE_ADMIN, ROLE_MEMBER etc ...
        } else {
            $roles[] = 'ROLE_USER'; // par defaut si notre utilisateur a été stocké dans role on retournera role_user pour que symfony ne plante pas
        }
        return $roles;
    }

    public function getRole(): ?role
    {
        return $this->role;
    }

    public function setRole(?role $role): self
    {
        $this->role = $role;

        return $this;
    }

        /** @see \Serializable::serialize() */
        public function serialize()
        {
            return serialize([
                $this->id,
                $this->username,
                $this->password,
                // see section on salt below
                // $this->salt,
            ]);
        }
        /** @see \Serializable::unserialize() */
        public function unserialize($serialized)
        {
            list (
                $this->id,
                $this->username,
                $this->password,
                // see section on salt below
                // $this->salt
            ) = unserialize($serialized, ['allowed_classes' => false]);
        }
    
    public function __toString()
    {
        return "$this->id";
    }

    public function setUsername(?string $username): self
    {
        $this->username = $username;

        return $this;
    }
}
