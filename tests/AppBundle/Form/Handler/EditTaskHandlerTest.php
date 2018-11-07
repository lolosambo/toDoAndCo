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

use AppBundle\Form\Handler\EditTaskHandler;
use AppBundle\Models\Repository\Interfaces\TaskRepositoryInterface;
use Symfony\Component\Form\Test\TypeTestCase;

/**
 * Class EditTaskHandlerTest
 *
 * @author Laurent BERTON <lolosambo2@gmail.com>
 */
class EditTaskHandlerTest extends TypeTestCase
{
    private $handler;

    /**
     * @group unit
     */
    public function testConstruct()
    {
        $repository = $this->createMock(TaskRepositoryInterface::class);
        $this->handler = new EditTaskHandler($repository);
        static::assertInstanceOf(EditTaskHandler::class, $this->handler);
    }
}
