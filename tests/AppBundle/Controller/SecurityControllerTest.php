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

use AppBundle\Controller\SecurityController;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class SecurityControllerTest
 *
 * @author Laurent BERTON <lolosambo2@gmail.com>
 */
class SecurityControllerTest extends WebTestCase
{
    private $client;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    /**
    * @group functional
    */
    public function testLoginAsUser()
    {
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form();
        $form['_username'] = 'toDoUser';
        $form['_password'] = 'MySuperPassword';
        $this->client->submit($form);
        $crawler = $this->client->followRedirect();
        $this->assertSame(1, $crawler->filter('html:contains("Bienvenue sur Todo List")')->count());
        $this->assertInstanceOf(Response::class, $this->client->getResponse());
    }

    /**
     * @group functional
     */
    public function testLoginAsAdmin()
    {
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form();
        $form['_username'] = 'toDoAdmin';
        $form['_password'] = 'MySuperPassword';
        $this->client->submit($form);
        $crawler = $this->client->followRedirect();
        $this->assertSame(1, $crawler->filter('html:contains("Bienvenue sur Todo List")')->count());
        $this->assertInstanceOf(Response::class, $this->client->getResponse());
    }

    /**
     * @group functional
     */
    public function testLoginInvalidCredentials()
    {
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form();
        $form['_username'] = 'invalid_username';
        $form['_password'] = 'password';
        $this->client->submit($form);
        $crawler = $this->client->followRedirect();
        $this->assertSame(1, $crawler->filter('div.alert.alert-danger:contains("Invalid credentials")')->count());
    }

    public function testLoginChekAction()
    {
        $action = new SecurityController();
        $result = $action->loginCheck();
        self::assertNull($result);
    }

    public function testLogoutAction()
    {
        $action = new SecurityController();
        $result = $action->logoutCheck();
        self::assertNull($result);
    }
}
