<?php

namespace AppBundle\Models\Entity\Interfaces;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class Task
 */
interface TaskInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return \Datetime
     */
    public function getCreatedAt();

    /**
     * @param $createdAt
     */
    public function setCreatedAt($createdAt);

    /**
     * @return mixed
     */
    public function getTitle();

    /**
     * @param $title
     */
    public function setTitle($title);

    /**
     * @return mixed
     */
    public function getContent();

    /**
     * @param $content
     */
    public function setContent($content);

    /**
     * @return bool
     */
    public function isDone();

    /**
     * @param $flag
     */
    public function toggle($flag);

    /**
     * @return User
     */
    public function getUser();

    /**
     * @param UserInterface $user
     */
    public function setUser(UserInterface $user): void;
}
