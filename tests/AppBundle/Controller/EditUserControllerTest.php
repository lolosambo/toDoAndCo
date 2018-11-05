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

use AppBundle\Models\DataFixtures\ORM\UsersFixtures;
use AppBundle\Models\Entity\User;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/**
 * Class EditUserControllerTest
 *
 * @author Laurent BERTON <lolosambo2@gmail.com>
 */
class EditUserControllerTest extends WebTestCase
{
    private $client;
    private $entityManager;

    public function setUp()
    {
        $this->client = static::createClient();
        $this->entityManager = static::$kernel->getContainer()->get('doctrine')->getManager();
        $UsersFixtures = new UsersFixtures();
        $loader = new Loader();
        $loader->addFixture($UsersFixtures);
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
    public function testEditUserActionAsAdmin()
    {
        $this->logInAs('toDoAdmin');
        $user = new User('testUserUsername', 'TestPassword', "test@test.com", "ROLE_ADMIN");
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        $crawler = $this->client->request('GET', '/users/'.$user->getId().'/edit');
        $form = $crawler->selectButton('Modifier')->form();
        $form['user[username]'] = 'UserTest';
        $form['user[password][first]'] = 'SomePassword';
        $form['user[password][second]'] = 'SomePassword';
        $form['user[email]'] = 'UserTest@user.com';
        $form['user[role]'] = 'ROLE_USER';
        $this->client->submit($form);
        static::assertEquals(302, $this->client->getResponse()->getStatusCode());
        $crawler = $this->client->followRedirect();
        static::assertEquals(200, $this->client->getResponse()->getStatusCode());
        static::assertSame(1, $crawler->filter('html:contains("L\'utilisateur a bien été modifié")')->count());
    }

    /**
     * @group functional
     */
    public function testEditUserActionAsUser()
    {
        $this->logInAs('toDoUser');
        $user = new User('testUser', 'ACertainPassword', 'user@user.com', 'ROLE_USER');
        $passwordEncoder = $this->client->getContainer()->get('security.password_encoder');
        $passwordEncode = $passwordEncoder->encodePassword($user, 'password');
        $user->setPassword($passwordEncode);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        $this->client->request('GET', 'users/'. $user->getId() .'/edit');
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
        $this->assertInstanceOf(RedirectResponse::class, $this->client->getResponse());
    }

}