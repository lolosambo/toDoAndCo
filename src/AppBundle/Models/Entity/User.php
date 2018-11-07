<?php

namespace AppBundle\Models\Entity;

use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class User
 */
class User implements UserInterface
{
    /**
     * @var int $id
     */
    private $id;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var null|string
     */
    private $email;

    /**
     * @var string $role
     */
    private $role;

    /**
     * @var array
     */
    private $tasks;


    /**
     * User constructor.
     *
     * @param string|null $username
     * @param string|null $password
     * @param string|null $email
     * @param string|null $role
     */
    public function __construct(
        string $username = null,
        string $password = null,
        string $email = null,
        string $role = null
    ) {
        $this->username = $username;
        $this->password= $password;
        $this->email = $email;
        $this->role = $role;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return null|string
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param $email
     */
    public function setEmail($email)
    {
        if (preg_match('#^([0-9a-zA-Z-_]+)@([0-9a-zA-Z-_]+).([a-z]+)$#', $email)) {
            $this->email = $email;
            return true;
        }
        return false;
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        return ['ROLE_USER', 'ROLE_ADMIN'];
    }

    /**
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param string $role
     */
    public function setRole(string $role)
    {
        $this->role = $role;
    }

    /**
     *
     */
    public function eraseCredentials()
    {
        return null;
    }

    /**
     * @return array
     */
    public function getTasks()
    {
        return $this->tasks;
    }

    /**
     * @param Task $task
     */
    public function addTask(Task $task)
    {
        $this->tasks[] = $task;
        $task->setUser($this);
        return $this;
    }
}
