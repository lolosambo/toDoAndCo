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
namespace Tests\Controller;
use AppBundle\Form\Handler\CreateUserHandler;
use AppBundle\Controller\CreateUserController;
use AppBundle\Models\Repository\Interfaces\UserRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Twig\Environment;
/**
 * Class CreateUserControllerTest
 *
 * @author Laurent BERTON <lolosambo2@gmail.com>
 */
class CreateUserControllerTest extends WebTestCase
{
    protected static $container;
    private $factory;
    private $handler;
    private $repository;
    private $encoder;
    private $generator;
    private $twig;

    public function setUp()
    {
        static::bootKernel();
        self::$container = static::$kernel->getContainer();

        $this->factory = self::$container->get('form.factory');
        $this->twig = $this->createMock(Environment::class);
        $this->repository = $this->createMock(UserRepositoryInterface::class);
        $this->encoder = $this->createMock(UserPasswordEncoderInterface::class);
        $this->generator = $this->createMock(UrlGeneratorInterface::class);
        $this->handler = new CreateUserhandler($this->repository, $this->encoder);
    }

    /**
     * @group unit
     */
    public function test_construct()
    {
        $action = new CreateUserController($this->repository, $this->twig, $this->factory, $this->generator, $this->encoder);
        static::assertInstanceOf(CreateUserController::class, $action);
    }

    /**
     * @group unit
     *
     * @covers CreateUserController::__invoke
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function testCreateUserAction()
    {
        $request= Request::create(
            '/users/create',
            'POST'
        );
        $action = new CreateUserController(
            $this->repository,
            $this->twig,
            $this->factory,
            $this->generator,
            $this->encoder
        );
        $result = $action(
            $request,
            $this->handler
        );
        static::assertInstanceOf(Response::class, $result);
    }
}