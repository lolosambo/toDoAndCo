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

use AppBundle\Form\Handler\CreateTaskHandler;
use AppBundle\Models\Repository\Interfaces\TaskRepositoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Csrf\TokenStorage\TokenStorageInterface;

/**
 * Class CreateTaskHandlerTest
 *
 * @author Laurent BERTON <lolosambo2@gmail.com>
 */
class CreateTaskHandlerTest extends TypeTestCase
{
    private $handler;

    /**
     * @group unit
     */
    public function testConstruct()
    {
        $repository = $this->createMock(TaskRepositoryInterface::class);
        $token = $this->createMock(TokenStorageInterface::class);
        $container = $this->createMock(ContainerInterface::class);
        $security = new Security($container);

        $this->handler = new CreateTaskHandler($repository, $token, $security);
        static::assertInstanceOf(CreateTaskHandler::class, $this->handler);
    }
}
