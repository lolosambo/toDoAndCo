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
use Doctrine\Common\Collections\Collection;
use PHPUnit\Framework\TestCase;

/**
 * Class UserTest
 *
 * @author Laurent BERTON <lolosambo2@gmail.com>
 */
class UserTest extends TestCase
{
    private $user;

    public function setUp()
    {
        $user = new User(
            "TestUser",
            "MySuperPassword",
            'test@test.com',
            'ROLE_USER'
        );
        $this->user = $user;
    }

    /**
     * @group unit
     *
     * @covers User::__construct
     */
    public function testUserConstruct()
    {
        static::assertInstanceof(User::class, $this->user);
    }
    /**
     * @group unit
     */
    public function testUserAttributes()
    {
        static::assertObjectHasAttribute('id', $this->user);
        static::assertObjectHasAttribute('username', $this->user);
        static::assertObjectHasAttribute('password', $this->user);
        static::assertObjectHasAttribute('email', $this->user);
        static::assertObjectHasAttribute('role', $this->user);
        static::assertObjectHasAttribute('tasks', $this->user);

    }

    /**
     * @group unit
     *
     * @covers User::getId
     */
    public function testUserMustHaveIdEqualToNull()
    {
        static::assertNull($this->user->getId());
    }

    /**
     * @group unit
     *
     * @covers User::getUsername
     */
    public function testUserMustHaveValidUsername()
    {
        static::assertInternalType('string', $this->user->getUsername());
    }

    /**
     * @group unit
     *
     * @covers User::setUsername
     */
    public function testUserShouldBeAbleToChangeUsername()
    {
        $this->user->setUsername('changedUser');
        static::assertContains('changedUser', $this->user->getUsername());
    }

    /**
     * @group unit
     *
     * @covers User::getPassword
     */
    public function testUserMustHaveValidPassword()
    {
        static::assertInternalType('string', $this->user->getPassword());
    }

    /**
     * @group unit
     *
     * @covers User::setPassword
     */
    public function testUserShouldBeAbleToChangePassword()
    {
        $this->user->setPassword('anotherPassword');
        static::assertContains('anotherPassword', $this->user->getPassword());
    }

    /**
     * @group unit
     *
     * @covers User::getEmail
     */
    public function testUserMustHaveValidEmail()
    {
        static::assertInternalType('string', $this->user->getEmail());
    }

    /**
     * @group unit
     *
     * @covers User::setEmail
     */
    public function testUserShouldBeAbleToChangeEmail()
    {
        $this->user->setEmail('changedEmail@test.com');
        static::assertContains('changedEmail@test.com', $this->user->getEmail());
    }

    /**
     * @group unit
     *
     * @covers User::getRole
     */
    public function testUserMustHaveValidRole()
    {
        static::assertInternalType('string', $this->user->getRole());
    }

    /**
     * @group unit
     *
     * @covers User::setRole
     */
    public function testUserShouldBeAbleToChangeRole()
    {
        $this->user->setRole('ROLE_USER');
        static::assertContains('ROLE_USER', $this->user->getRole());
    }

    /**
     * @group unit
     *
     * @covers User::getTasks
     */
    public function testUserMustHaveValidTasks()
    {
        $task = new Task('testTitle', 'TestContent');
        $this->user->addTask($task);
        static::assertInternalType('array', $this->user->getTasks());
    }

    /**
     * @group unit
     *
     * @covers User::eraseCredentials
     */
    public function testUserMustHaveUnusedEraseCredentialsMethod()
    {
        static::assertNull($this->user->eraseCredentials());
    }

    /**
     * @group unit
     *
     * @covers User::getSalt
     */
    public function testUserMustHaveUnusedGetSaltMethod()
    {
        static::assertNull($this->user->getSalt());
    }

    /**
     * @group unit
     *
     * @covers User::getRoles
     */
    public function testUserMustHaveValidRoles()
    {
        static::assertInternalType('array', $this->user->getRoles());
        static::assertCount(2, $this->user->getRoles());
    }

    /**
     * @group unit
     *
     * @covers User::addTask
     */
    public function testUserShouldBeAbleToAddATask()
    {
        $task = new Task('testTitle', 'TestContent');
        $this->user->addTask($task);
        static::assertCount(1, $this->user->getTasks());
    }

    /**
     * @group unit
     */
    public function testPasswordMustBeCrypted()
    {
        static::assertContains('MySuperPassword', $this->user->getPassword());
    }

    /**
     * @group unit
     */
    public function testEmailAddressMustMatchWithPattern()
    {
        static::assertTrue($this->user->setEmail('test@gmail.com'));
    }

    /**
     * @group unit
     */
    public function testEmailAddressMustReturnNullWithBadPattern()
    {
        static::assertFalse($this->user->setEmail('tes/t@gmail.com51'));
    }
}