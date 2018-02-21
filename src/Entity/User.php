<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class User
 *
 * @author Mathieu GUILLEMINOT <guilleminotm@gmail.com>
 *
 * @ApiResource(
 *     collectionOperations={
 *         "get"={"method"="GET", "access_control"="is_granted('ROLE_ADMIN')", "access_control_message"="Only admins can see all users"},
 *         "post"={"method"="POST", "access_control"="is_granted('ROLE_ADMIN')", "access_control_message"="Only admins can create users"}
 *     },
 *     itemOperations={
 *         "get"={"method"="GET", "access_control"="is_granted('ROLE_ADMIN') or object == user", "access_control_message"="You can only see your own user"},
 *         "put"={"method"="PUT", "access_control"="is_granted('ROLE_ADMIN')", "access_control_message"="Only admins can edit users"},
 *         "delete"={"method"="DELETE", "access_control"="is_granted('ROLE_ADMIN') and object != user", "access_control_message"="Only admins can delete users"}
 *     },
 *     attributes={
 *         "validation_groups"={"client_validation"},
 *         "normalization_context"={"groups"={"read"}},
 *         "denormalization_context"={"groups"={"write"}}
 *     }
 * )
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface, \Serializable
{
    /**
     * @var int
     *
     * @Groups({"read", "write"})
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=25, unique=true)
     */
    private $username;

    /**
     * @var string
     */
    private $plainPassword;

    /**
     * @var
     *
     * @Groups({"write"})
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @var string
     *
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", unique=true)
     */
    private $email;

    /**
     * @var boolean
     *
     * @Groups({"read", "write"})
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive = false;

    /**
     * @var array
     *
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var Client[]|ArrayCollection
     *
     * @ApiSubresource
     * @ORM\OneToMany(targetEntity="App\Entity\Client", cascade={"persist", "remove", "refresh"}, mappedBy="user", orphanRemoval=true)
     */
    private $clients;

    public function __construct()
    {
        $this->clients = new ArrayCollection();
    }

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
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    /**
     * @param string $plainPassword
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
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
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return boolean
     */
    public function getActive()
    {
        return $this->isActive;
    }

    /**
     * @param boolean $isActive
     */
    public function setActive($isActive)
    {
        $this->isActive = $isActive;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        $roles = $this->roles;

        if (empty($roles))
            $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param array $roles
     */
    public function setRoles(array $roles)
    {
        $this->roles = $roles;
    }

    /**
     * @return string
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     *
     */
    public function eraseCredentials()
    {
    }

    /**
     * @return string
     */
    public function serialize(): string
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            $this->isActive
        ));
    }

    /**
     * @param $serialized
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            $this->isActive
            ) = unserialize($serialized);
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return $this->isActive;
    }

    /**
     * @param Client $client
     */
    public function addClient(Client $client)
    {
        $this->clients[] = $client;
        $client->setUser($this);
    }

    /**
     * @param Client $client
     */
    public function removeClient(Client $client)
    {
        $this->clients->removeElement($client);
    }

    /**
     * @return Collection|Client[]
     */
    public function getClients(): Collection
    {
        return $this->clients;
    }
}
