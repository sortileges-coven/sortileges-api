<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\RegistrationController;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ApiResource(
    collectionOperations: [
        'register' => [
            'method' => 'POST',
            'path' => '/register',
            'controller' => RegistrationController::class,
            'openapi_context' => [
                'summary' => 'Register a new user',
                'requestBody' => [
                    'content' => [
                        'application/json' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
                                    'email' => ['type' => 'string', 'required' => 'true'],
                                    'password' => ['type' => 'string', 'required' => 'true', 'minLength' => 8],
                                    'pseudo' => ['type' => 'string', 'required' => 'true', 'minLength' => 3],
                                ],
                            ],
                            'example' => [
                                'email' => 'johndoe@example.com',
                                'password' => 'mySecr3tPasswOrd',
                                'pseudo' => 'johnDoe',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\OneToMany(mappedBy: 'witch', targetEntity: SigilSpell::class, orphanRemoval: true)]
    private Collection $sigilSpells;

    #[ORM\Column(length: 127, unique: true)]
    private ?string $pseudo = null;

    public function __construct()
    {
        $this->sigilSpells = new ArrayCollection();
    }

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
    public function getUserIdentifier(): string
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
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection<int, SigilSpell>
     */
    public function getSigilSpells(): Collection
    {
        return $this->sigilSpells;
    }

    public function addSigilSpell(SigilSpell $sigilSpell): self
    {
        if (!$this->sigilSpells->contains($sigilSpell)) {
            $this->sigilSpells->add($sigilSpell);
            $sigilSpell->setWitch($this);
        }

        return $this;
    }

    public function removeSigilSpell(SigilSpell $sigilSpell): self
    {
        if ($this->sigilSpells->removeElement($sigilSpell)) {
            // set the owning side to null (unless already changed)
            if ($sigilSpell->getWitch() === $this) {
                $sigilSpell->setWitch(null);
            }
        }

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }
}
