<?php

namespace AppBundle\Entity\Interfaces;

use AppBundle\Models\Entity\Task;

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
    public function getTasks(): array;

    /**
     * @param Task $task
     */
    public function addTask(Task $task): void;
    /**
     * @param Task $task
     */
    public function removeTask(Task $task): void;

}
