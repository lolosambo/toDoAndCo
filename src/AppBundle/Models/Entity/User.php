<?php

namespace AppBundle\Models\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\NotBlank(message="Vous devez saisir un nom d'utilisateur.")
     */
    private $username;

    /**
     * @var string $password
     */
    private $password;

    /**
     * var string $email
     * @Assert\NotBlank(message="Vous devez saisir une adresse email.")
     * @Assert\Email(message="Le format de l'adresse n'est pas correcte.")
     */
    private $email;

    /**
     * @var string $role
     */
    private $role;

    /**
     * @var array Task
     */
    private $tasks = [];


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
        $this->email = $email;
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        return ['ROLE_USER', 'ROLE_ADMIN'];
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
    }

    /**
     * @return array
     */
    public function getTasks(): array
    {
        return $this->tasks;
    }

    /**
     * @param Task $task
     */
    public function addTask(Task $task): void
    {
        $this->tasks[] = $task;
    }

    /**
     * @param Task $task
     */
    public function removeTask(Task $task): void
    {
        $index = array_search($task, $this->getTasks());
        if($index !== false){
            unset($this->getTasks()[$index]);
        }
    }
}
