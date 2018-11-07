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

use AppBundle\Models\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/**
 * Class ShowAllTasksControllerTest
 *
 * @author Laurent BERTON <lolosambo2@gmail.com>
 */
class ShowAllTasksControllerTest extends WebTestCase
{
    private $client;

    public function setUp()
    {
        $this->client = static::createClient();
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
    public function testAllTasksAsAnonymous()
    {
        $crawler = $this->client->request('GET', '/tasks');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Se connecter")')->count());
        $this->assertInstanceOf(Response::class, $this->client->getResponse());
    }

    /**
     * @group functional
     */
    public function testListTasksAsUserAction()
    {
        $this->logInAs('toDoUser');
        $crawler = $this->client->request('GET', '/tasks');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Créer une tâche")')->count());
        $this->assertInstanceOf(Response::class, $this->client->getResponse());
    }

    /**
     * @group functional
     */
    public function testListTasksAsAdminAction()
    {
        $this->logInAs('toDoAdmin');
        $crawler = $this->client->request('GET', '/tasks');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Créer une tâche")')->count());
        $this->assertInstanceOf(Response::class, $this->client->getResponse());
    }
}
