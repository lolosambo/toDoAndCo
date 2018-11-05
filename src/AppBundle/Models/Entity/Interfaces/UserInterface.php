<?php

namespace AppBundle\Models\Entity\Interfaces;

use AppBundle\Models\Entity\Task;
use Doctrine\Common\Collections\Collection;

/**
 * Interface UserInterface
 */
interface UserInterface
{

    /**
     * @return mixed
     */
    public function getId();

    /**
     * @return string
     */
    public function getUsername();

    /**
     * @param $username
     */
    public function setUsername($username);

    /**
     * @return null|string
     */
    public function getSalt();

    /**
     * @return string
     */
    public function getPassword();

    /**
     * @param $password
     */
    public function setPassword($password);

    /**
     * @return mixed
     */
    public function getEmail();

    /**
     * @param $email
     */
    public function setEmail($email);

    /**
     * @return string
     */
    public function getRoles();

    public function eraseCredentials();

    /**
     * @return array
     */
    public function getTasks();

    /**
     * @param Task $task
     */
    public function addTask(Task $task);

}
