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

use AppBundle\Models\DataFixtures\ORM\TasksFixtures;
use AppBundle\Models\Entity\Task;
use AppBundle\Models\Entity\User;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/**
 * Class DeleteTaskControllerTest
 *
 * @author Laurent BERTON <lolosambo2@gmail.com>
 */
class DeleteTaskControllerTest extends WebTestCase
{
    private $client;

    public function setUp()
    {
        $this->client = static::createClient();
        $entityManager = static::$kernel->getContainer()->get('doctrine')->getManager();
        $productsFixtures = new TasksFixtures();
        $loader = new Loader();
        $loader->addFixture($productsFixtures);
        $purger = new ORMPurger($entityManager);
        $executor = new ORMExecutor(
            $entityManager,
            $purger
        );
        $executor->execute($loader->getFixtures());
    }

    public function logInAs($username)
    {
        $session = $this->client->getContainer()->get('session');
        $firewallContext = 'main';
        $user = $this->client->getContainer()->get('doctrine')->getManager()->getRepository(User::class)->findOneByUsername($username);
        $token = new UsernamePasswordToken($user, $user->getPassword(), $firewallContext, $user->getRoles());
        $session->set('_security_'.$firewallContext, serialize($token));
        $session->save();
        return $user;
    }

    /**
     * @group functional
     */
    public function testDeleteTaskAsUserAction()
    {
        $user = $this->logInAs('toDoUser');
        $task = $user = $this->client->getContainer()->get('doctrine')->getManager()->getRepository(Task::class)->findAll()[0];
        $this->client->request('GET', 'tasks/'. $task->getId() .'/delete');
        $response = $this->client->getResponse();
        $this->assertSame(302, $response->getStatusCode());
        $crawler = $this->client->followRedirect();
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('div.alert-success:contains("Superbe ! La tâche a bien été supprimée.")')->count());
        $this->assertInstanceOf(Response::class, $this->client->getResponse());
    }

    /**
     * @group functional
     */
    public function testDeleteTaskAsNotGoodUserAction()
    {
        $this->logInAs('AnonymousUser');
        $task = $this->client->getContainer()->get('doctrine')->getManager()->getRepository(Task::class)->findAll()[0];
        $this->client->request('GET', 'tasks/'. $task->getId() .'/delete');
        $response = $this->client->getResponse();
        $this->assertSame(302, $response->getStatusCode());
        $this->assertInstanceOf(RedirectResponse::class, $this->client->getResponse());
    }

    /**
     * @group functional
     */
    public function testDeleteTaskAsAdminAction()
    {
        $this->logInAs('toDoAdmin');
        $task = $this->client->getContainer()->get('doctrine')->getManager()->getRepository(Task::class)->findAll()[0];
        $this->client->request('GET', 'tasks/'. $task->getId() .'/delete');
        $response = $this->client->getResponse();
        $this->assertSame(302, $response->getStatusCode());
        $crawler = $this->client->followRedirect();
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('div.alert-success:contains("Superbe ! La tâche a bien été supprimée.")')->count());
        $this->assertInstanceOf(Response::class, $this->client->getResponse());
    }

}