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
use AppBundle\Models\DataFixtures\ORM\UsersFixtures;
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
 * Class CreateUserControllerTest
 *
 * @author Laurent BERTON <lolosambo2@gmail.com>
 */
class CreateUserControllerTest extends WebTestCase
{
    private $client;

    private $entityManager;

    public function setUp()
    {
        $this->client = static::createClient();
        $this->entityManager = static::$kernel->getContainer()->get('doctrine')->getManager();
        $usersFixtures = new UsersFixtures();
        $loader = new Loader();
        $loader->addFixture($usersFixtures);
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
     * @covers CreateUserHandler::handle
     */
    public function testCreateUserAsAdmin()
    {
        $this->logInAs('toDoAdmin');
        $crawler = $this->client->request('GET', '/users/create');
        $form = $crawler->selectButton('Ajouter')->form();
        $form['user[username]'] = 'UserTest';
        $form['user[password][first]'] = 'SomePassword';
        $form['user[password][second]'] = 'SomePassword';
        $form['user[email]'] = 'UserTest@user.com';
        $form['user[role]'] = 'ROLE_USER';
        $this->client->submit($form);
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
        $crawler = $this->client->followRedirect();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Superbe ! L\'utilisateur a bien été ajouté. Vous pouvez maintenant vous connecter.")')->count());
        $this->assertInstanceOf(Response::class, $this->client->getResponse());
    }

    /**
     * @group functional
     */
    public function testCreateUserAsUser()
    {
        $this->logInAs('toDoUser');
        $crawler = $this->client->request('GET', '/users/create');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Créer un utilisateur")')->count());
        $this->assertInstanceOf(Response::class, $this->client->getResponse());
    }

}