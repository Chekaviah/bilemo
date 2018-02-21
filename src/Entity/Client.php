<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * Class Client
 *
 * @author Mathieu GUILLEMINOT <guilleminotm@gmail.com>
 *
 * @ApiResource(
 *     collectionOperations={
 *         "get"={"method"="GET", "access_control"="is_granted('ROLE_ADMIN')", "access_control_message"="Only admins can see all clients"},
 *         "post"={"route_name"="api_client_post_collection_custom"}
 *     },
 *     itemOperations={
 *         "get"={"method"="GET", "access_control"="is_granted('ROLE_ADMIN') or object.getUser() == user", "access_control_message"="You can see only your own clients"},
 *         "put"={"method"="PUT", "access_control"="is_granted('ROLE_ADMIN') or object.getUser() == user", "access_control_message"="You can edit only your own clients"},
 *         "delete"={"method"="DELETE", "access_control"="is_granted('ROLE_ADMIN') or object.getUser() == user", "access_control_message"="You can delete only your own clients"},
 *     },
 *     attributes={
 *         "validation_groups"={"client_validation"}
 *     }
 * )
 * @ApiFilter(SearchFilter::class, properties={"user.id": "exact"})
 * @ORM\Entity(repositoryClass="App\Repository\ClientRepository")
 */
class Client
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=30)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="clients")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress(string $address)
    {
        $this->address = $address;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }
}
