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
namespace Tests\Handler;

use AppBundle\Form\Handler\CreateUserHandler;
use AppBundle\Form\Handler\EditUserHandler;
use AppBundle\Models\Repository\Interfaces\UserRepositoryInterface;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class EditUserHandlerTest
 *
 * @author Laurent BERTON <lolosambo2@gmail.com>
 */
class EditUserHandlerTest extends TypeTestCase
{
    private $handler;

    /**
     * @group unit
     */
    public function testConstruct()
    {
        $repository = $this->createMock(UserRepositoryInterface::class);
        $encoder = $this->createMock(UserPasswordEncoderInterface::class);
        $this->handler = new EditUserHandler($repository, $encoder);
        static::assertInstanceOf(EditUserHandler::class, $this->handler);
    }
}
