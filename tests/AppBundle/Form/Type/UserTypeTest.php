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

use AppBundle\Form\DTO\UserDTO;
use AppBundle\Form\Handler\CreateUserHandler;
use AppBundle\Form\Type\UserType;
use Symfony\Component\Form\Test\TypeTestCase;

/**
 * Class UserTypeTest
 *
 * @author Laurent BERTON <lolosambo2@gmail.com>
 */
class UserTypeTest extends TypeTestCase
{
    /**
     * @group unit
     *
     * @covers UserType::buildForm
     * @covers UserType::configureOptions
     * @covers CreateUserHandler::handle
     */
    public function testAddUserForm()
    {
        $formData = array(
            'username' => 'TestUser',
            'password' => ['first' => 'SomePassword', 'second' => 'SomePassword'],
            'email' => 'test@test.com',
            'role' => 'ROLE_ADMIN'
        );

        $objectToCompare = new UserDTO();
        $form = $this->factory->create(UserType::class, $objectToCompare);

        $object = new UserDTO('TestUser', 'SomePassword', 'test@test.com', 'ROLE_ADMIN');
        $form->submit($formData);

        static::assertTrue($form->isSynchronized());
        static::assertEquals($object, $objectToCompare);

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            static::assertArrayHasKey($key, $children);
        }
    }
}
