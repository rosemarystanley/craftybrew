<?php

declare(strict_types=1);

namespace CraftyBrew\WebBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User implements UserInterface
{
    /**
     * @ORM\Column(name="api_key", type="string", length=128, unique=true, nullable=true)
     *
     * @var string|null
     */
    private $apiKey;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id", type="integer")
     *
     * @var integer|null
     */
    private $id;

    /**
     * @ORM\Column(name="password", type="string", length=128, nullable=true)
     *
     * @var string|null
     */
    private $password;

    /**
     * @ORM\Column(name="username", type="string", length=255, unique=true)
     *
     * @var string
     */
    private $username;

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
    }

    /**
     * @return null|string
     */
    public function getApiKey(): ?string
    {
        return $this->apiKey;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return null|string
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return string[] The user roles
     */
    public function getRoles()
    {
        if ($this->apiKey) {
            return ['ROLE_API_USER'];
        }

        return ['ROLE_WEB_USER'];
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param null|string $apiKey
     *
     * @return User
     */
    public function setApiKey(?string $apiKey): User
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    /**
     * @param int|null $id
     *
     * @return User
     */
    public function setId(?int $id): User
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param null|string $password
     *
     * @return User
     */
    public function setPassword(?string $password): User
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @param string $username
     *
     * @return User
     */
    public function setUsername(string $username): User
    {
        $this->username = $username;

        return $this;
    }
}
