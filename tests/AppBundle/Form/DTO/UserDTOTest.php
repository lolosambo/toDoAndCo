<?php
declare(strict_types=1);
/*
 * This file is part of the SnowTricks project.
 *
 * (c) Laurent BERTON <lolosambo2@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Tests\AppBundle\Form\DTO;

use AppBundle\Form\DTO\UserDTO;
use PHPUnit\Framework\TestCase;

/**
 * Class UserDTOTest
 *
 *  @author Laurent BERTON <lolosambo2@gmail.com>
 */
class UserDTOTest extends TestCase
{
    /**
     * @var UserDTO
     */
    private $dto;

    public function setUp()
    {
        $dto = new UserDTO(
            'lolosambo',
            'a-standard-password',
            'lolosambo2@gougueule.com',
            'ROLE_ADMIN'
        );
        $this->dto = $dto;
    }
    /**
     * @group unit
     *
     * @covers AppBundle\Form\DTO\UserDTO
     */
    public function testUsernameAttributeMustBeAString()
    {
        static::assertInternalType('string', $this->dto->username);
    }

    /**
     * @group unit
     *
     * @covers AppBundle\Form\DTO\UserDTO
     *
     */
    public function testPasswordAttributeMustBeAString()
    {
        static::assertInternalType('string', $this->dto->password);
    }

    /**
     * @group unit
     *
     * @covers AppBundle\Form\DTO\UserDTO$
     *
     */
    public function testEmailAttributeMustBeAString()
    {
        static::assertInternalType('string', $this->dto->email);
    }

    /**
     * @group unit
     *
     * @covers AppBundle\Form\DTO\UserDTO
     *
     */
    public function testEmailAttributeMustBeCompatibleWithRegex()
    {
        static::assertRegExp(
            '#([a-zA-Z0-9-_]+)@([a-zA-Z0-9-_]+).([a-zA-Z]+)#',
            $this->dto->email
        );
    }
}
