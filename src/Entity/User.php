<?php
declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

use function array_unique;
use function in_array;
use function strtoupper;

/**
 * Class User
 * @package App\Entity
 *
 * @ApiResource(
 *     attributes={
 *         "order"={"email": "ASC"},
 *         "normalization_context"={"groups"={"read"}},
 *         "denormalization_context"={"groups"={"write"}}
 *     },
 *     collectionOperations={
 *         "get"={"access_control"="is_granted('ROLE_ADMIN')"},
 *         "post"={
 *             "route_name"="api_users_post",
 *             "access_control"="is_granted('ROLE_ADMIN')"
 *         }
 *     },
 *     itemOperations={
 *         "get"={"access_control"="is_granted('ROLE_ADMIN')"},
 *         "put"={
 *             "route_name"="api_users_put",
 *             "access_control"="is_granted('ROLE_ADMIN')"
 *         },
 *         "delete"={"access_control"="is_granted('ROLE_ADMIN')"}
 *     }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="user")
 */
class User implements UserInterface
{
    /**
     * @var Uuid
     * @ApiProperty(iri="http://schema.org/identifier")
     * @ORM\Id
     * @ORM\Column(name="id", type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     * @ApiProperty(
     *     attributes={
     *         "swagger_context"={"type"="string", "format"="uuid"}
     *     }
     * )
     * @Groups({"read"})
     */
    protected $id;

    /**
     * @var string
     * @ApiProperty(iri="http://schema.org/email")
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups({"read","write"})
     */
    protected $email;

    /**
     * @var string[]
     * @ORM\Column(type="array")
     * @ApiProperty(
     *     attributes={
     *          "swagger_context"={
     *              "type"="array",
     *              "enum"={
     *                  "ROLE_USER",
     *                  "ROLE_AUTHOR",
     *                  "ROLE_EDITOR",
     *                  "ROLE_ADMIN",
     *                  "ROLE_SUPER_ADMIN"
     *              },
     *              "example"="ROLE_USER"
     *          }
     *     }
     * )
     * @Groups({"read"})
     */
    protected $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Groups({"write"})
     */
    protected $password;

    /**
     * @var string|null
     * @ApiProperty(iri="http://schema.org/name")
     * @ORM\Column(name="name", type="string", length=50, nullable=true)
     * @Groups({"read","write"})
     */
    protected $name;

    /**
     * @var string|null
     * @ORM\Column(name="surname", type="string", length=50, nullable=true)
     * @Groups({"read","write"})
     */
    protected $surname;

    /**
     * @var DateTime|null
     * @ApiProperty(iri="http://schema.org/Date")
     * @ORM\Column(name="birthday", type="date", nullable=true)
     * @Assert\Date
     * @ApiProperty(
     *     attributes={
     *         "swagger_context"={"type"="string", "format"="date"}
     *     }
     * )
     * @Groups({"read","write"})
     */
    protected $birthday;

    /**
     * @var string|null
     * @ORM\Column(name="phone", type="string", length=50, nullable=true)
     * @Groups({"read","write"})
     */
    protected $phone;

    /**
     * @var string|null
     * @ORM\Column(name="mobile", type="string", length=50, nullable=true)
     * @Groups({"read","write"})
     */
    protected $mobile;

    /**
     * @var DateTime
     * @ApiProperty(iri="http://schema.org/DateTime")
     * @ORM\Column(name="created_at", type="datetime")
     * @Assert\DateTime
     * @ApiProperty(
     *     attributes={
     *         "swagger_context"={"type"="string", "format"="datetime"}
     *     }
     * )
     * @Groups({"read"})
     */
    protected $createdAt;

    /**
     * @var DateTime
     * @ApiProperty(iri="http://schema.org/DateTime")
     * @ORM\Column(name="updated_at", type="datetime")
     * @Assert\DateTime
     * @ApiProperty(
     *     attributes={
     *         "swagger_context"={"type"="string", "format"="datetime"}
     *     }
     * )
     * @Groups({"read"})
     */
    protected $updatedAt;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->setCreatedAt(new DateTime('now'));
        $this->setUpdatedAt(new DateTime('now'));
        $this->roles = ['ROLE_USER'];
    }

    /**
     * Adds a role to the user.
     *
     * @param $role
     * @return User
     */
    public function addRole($role)
    {
        $role = strtoupper($role);
        if ($role === 'ROLE_USER') {
            return $this;
        }

        if (!in_array($role, $this->roles, true)) {
            $this->roles[] = $role;
        }

        return $this;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps()
    {
        $this->setUpdatedAt(new DateTime('now'));

        if ($this->getCreatedAt() === null) {
            $this->setCreatedAt(new DateTime('now'));
        }
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

    /**
     * @return Uuid
     */
    public function getId(): Uuid
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return User
     */
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

    /**
     * @param array $roles
     * @return User
     */
    public function setRoles(array $roles): self
    {
        $this->roles = [];

        foreach ($roles as $role) {
            $this->addRole($role);
        }

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    /**
     * @param string $password
     * @return User
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return User
     */
    public function setName(?string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSurname(): ?string
    {
        return $this->surname;
    }

    /**
     * @param string|null $surname
     * @return User
     */
    public function setSurname(?string $surname): self
    {
        $this->surname = $surname;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getBirthday(): ?DateTime
    {
        return $this->birthday;
    }

    /**
     * @param DateTime|null $birthday
     * @return User
     */
    public function setBirthday(?DateTime $birthday): self
    {
        $this->birthday = $birthday;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param string|null $phone
     * @return User
     */
    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getMobile(): ?string
    {
        return $this->mobile;
    }

    /**
     * @param string|null $mobile
     * @return User
     */
    public function setMobile(?string $mobile): self
    {
        $this->mobile = $mobile;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     * @return User
     */
    public function setCreatedAt(DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTime $updatedAt
     * @return User
     */
    public function setUpdatedAt(DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
}
