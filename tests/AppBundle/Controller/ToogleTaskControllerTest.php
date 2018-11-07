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
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/**
 * Class ToogleTaskControllerTest
 *
 * @author Laurent BERTON <lolosambo2@gmail.com>
 */
class ToogleTaskControllerTest extends WebTestCase
{
    private $client;
    private $entityManager;

    public function setUp()
    {
        $this->client = static::createClient();
        $this->entityManager = static::$kernel->getContainer()->get('doctrine')->getManager();
        $productsFixtures = new TasksFixtures();
        $loader = new Loader();
        $loader->addFixture($productsFixtures);
        $purger = new ORMPurger($this->entityManager);
        $executor = new ORMExecutor(
            $this->entityManager,
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
        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
        return $user;
    }

    /**
     * @group functional
     */
    public function testToogleTaskAsuser()
    {
        $user = $this->logInAs('toDoUser');
        $task = new Task('testTitle', 'Some content');
        $task->setUser($user);
        $this->entityManager->persist($task);
        $this->entityManager->flush();
        $this->client->request('GET', 'tasks/'. $task->getId() .'/toggle');
        $response = $this->client->getResponse();
        $this->assertSame(302, $response->getStatusCode());
        $crawler = $this->client->followRedirect();
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('div.alert-success:contains("a bien été marquée comme faite.")')->count());
        $this->assertInstanceOf(Response::class, $this->client->getResponse());
    }

    /**
     * @group functional
     */
    public function testToogleTaskAsAdmin()
    {
        $user = $this->logInAs('toDoAdmin');
        $task = new Task('testTitle', 'Some content');
        $task->setUser($user);
        $this->entityManager->persist($task);
        $this->entityManager->flush();
        $this->client->request('GET', 'tasks/'. $task->getId() .'/toggle');
        $response = $this->client->getResponse();
        $this->assertSame(302, $response->getStatusCode());
        $crawler = $this->client->followRedirect();
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('div.alert-success:contains("a bien été marquée comme faite.")')->count());
        $this->assertInstanceOf(Response::class, $this->client->getResponse());
    }
}
