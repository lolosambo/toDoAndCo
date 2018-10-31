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
namespace Tests\Type;

use AppBundle\Form\DTO\TaskDTO;
use AppBundle\Form\Type\TaskType;
use Symfony\Component\Form\Test\TypeTestCase;

/**
 * Class TaskTypeTest
 *
 * @author Laurent BERTON <lolosambo2@gmail.com>
 */
class TaskTypeTest extends TypeTestCase
{
    /**
     * @group unit
     *
     * @covers TaskType::buildForm
     * @covers TaskType::configureOptions
     *
     */
    public function testAddTaskForm()
    {
        $formData = array(
            'title' => 'Some Title',
            'content' => 'Some Content',
        );

        $objectToCompare = new TaskDTO();
        $form = $this->factory->create(TaskType::class, $objectToCompare);
        $object = new TaskDTO('Some Title', 'Some Content');
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($object, $objectToCompare);

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }
}
