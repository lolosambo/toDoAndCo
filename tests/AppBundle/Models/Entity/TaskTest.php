<?php
declare(strict_types=1);
/*
 * This file is part of the toDoAndCo project.
 *
 * (c) Laurent BERTON <lolosambo2@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Tests\AppBundle\Models;

use AppBundle\Models\Entity\Task;
use AppBundle\Models\Entity\User;
use PHPUnit\Framework\TestCase;

/**
 * Class TaskTest
 *
 * @author Laurent BERTON <lolosambo2@gmail.com>
 */
class TaskTest extends TestCase
{
    private $task;

    public function setUp()
    {
        $user = $this->createMock(User::class);
        $task = new Task(
            "TestTitle",
            "TestContent"
        );
        $task->setUser($user);
        $this->task = $task;
    }

    /**
     * @group unit
     *
     * @covers Task::__construct
     */
    public function testTaskConstruct()
    {
        static::assertInstanceof(Task::class, $this->task);
    }

    /**
     * @group unit
     *
     * @covers AppBundle\Models\Entity\Task
     */
    public function testTaskAttributes()
    {
        static::assertObjectHasAttribute('id', $this->task);
        static::assertObjectHasAttribute('title', $this->task);
        static::assertObjectHasAttribute('content', $this->task);
        static::assertObjectHasAttribute('isDone', $this->task);
        static::assertObjectHasAttribute('user', $this->task);
    }

    /**
     * @group unit
     *
     * @covers Task::getId
     */
    public function testTaskMustHaveIdEqualToNull()
    {
        static::assertNull($this->task->getId());
    }

    /**
    * @covers Task::getTitle
    */
    public function testTaskMustHaveValidTitle()
    {
        static::assertContains('TestTitle', $this->task->getTitle());
    }

    /**
     * @group unit
     *
     * @covers Task::setTitle
     */
    public function testTaskShouldBeAbleToChangeTitle()
    {
        $this->task->setTitle('changedTitle');
        static::assertContains('changedTitle', $this->task->getTitle());
    }

    /**
     * @covers Task::getContent
     */
    public function testTaskMustHaveValidContent()
    {
        static::assertContains('TestContent', $this->task->getContent());
    }

    /**
     * @group unit
     *
     * @covers Task::setContent
     */
    public function testTaskShouldBeAbleToChangeContent()
    {
        $this->task->setContent('changedTitle');
        static::assertContains('changedTitle', $this->task->getContent());
    }

    /**
     * @covers Task::getCreatedAt
     */
    public function testTaskMustHaveValidCreatedAt()
    {
        static::assertInstanceOf(\DateTime::class, $this->task->getCreatedAt());
    }

    /**
     * @group unit
     *
     * @covers Task::setCreatedAt
     */
    public function testTaskShouldBeAbleToChangeCreatedAt()
    {
        $newDate = new \Datetime('NOW');
        $this->task->setCreatedAt($newDate);
        static::assertInstanceOf(\DateTime::class, $this->task->getCreatedAt());
    }

    /**
     * @covers Task::isDone
     */
    public function testTaskMustHaveValidIsDone()
    {
        static::assertEquals(0, $this->task->isDone());
    }

    /**
     * @covers Task::toggle
     */
    public function testTaskShouldBeAbleToToogleAtask()
    {
        $this->task->toggle(1);
        static::assertEquals(1, $this->task->isDone());
    }

    /**
     * @covers Task::getUser
     */
    public function testTaskMustHaveValidUser()
    {
        static::assertInstanceOf(User::class, $this->task->getUser());
    }

    /**
     * @group unit
     *
     * @covers Task::setUser
     */
    public function testTaskShouldBeAbleToChangeUser()
    {
        $newUser = new User('newPseudo', 'newPass', 'newmail@test.com', 'ROLE_ADMIN');
        $this->task->setUser($newUser);
        static::assertContains('newPseudo', $this->task->getUser()->getusername());
    }

    /**
     * @group unit
     */
    public function testTaskMustHaveValidAttributes()
    {
        static::assertInternalType('string', $this->task->getTitle());
        static::assertInternalType('string', $this->task->getContent());
        static::assertInstanceOf(User::class, $this->task->getUser());
    }
}