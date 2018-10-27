<?php

namespace AppBundle\Models\Entity;

use AppBundle\Models\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Models\Entity\Interfaces\TaskInterface;

/**
 * Class Task
 */
class Task implements TaskInterface
{
    /**
     * @var int $id
     */
    private $id;

    /**
     * @var \Datetime
     */
    private $createdAt;

    /**
     * var string $title
     *
     * @Assert\NotBlank(message="Vous devez saisir un titre.")
     */
    private $title;

    /**
     * var string $content
     *
     * @Assert\NotBlank(message="Vous devez saisir du contenu.")
     */
    private $content;

    /**
     * var boolean $is_done
     */
    private $isDone;

    /**
     * @var User
     */
    private $user;


    public function __construct(
        string $title,
        string $content
    ) {
        $this->createdAt = new \Datetime();
        $this->isDone = false;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return \Datetime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return bool
     */
    public function isDone()
    {
        return $this->isDone;
    }

    /**
     * @param $flag
     */
    public function toggle($flag)
    {
        $this->isDone = $flag;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     *
     * @return void
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }
}
