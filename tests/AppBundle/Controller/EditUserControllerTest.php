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
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/**
 * Class EditUserControllerTest
 *
 * @author Laurent BERTON <lolosambo2@gmail.com>
 */
class EditUserControllerTest extends WebTestCase
{
    private $client;

    public function setUp()
    {
        $this->client = static::createClient();
        $em = static::$kernel->getContainer()->get('doctrine')->getManager();
        $productsFixtures = new UsersFixtures();
        $loader = new Loader();
        $loader->addFixture($productsFixtures);
        $purger = new ORMPurger($em);
        $executor = new ORMExecutor(
            $em,
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
     * @group unit
     */
    public function testEditUserAction()
    {
        $this->logInAs('toDoUser');
        $user = $this->client->getContainer()->get('doctrine')->getManager()->getRepository(User::class)->findOneByUsername('AnonymousUser');
        $crawler = $this->client->request('GET', 'users/'. $user->getId() .'/edit');
        $form = $crawler->selectButton('modify')->form();
        $form['user[username]'] = $user->getUsername();
        $form['user[password][first]'] = 'anotherPassword';
        $form['user[password][second]'] = 'anotherPassword';
        $form['user[email]'] = $user->getEmail();
        $form['user[role]'] = $user->getRole();
        $this->client->submit($form);
        $crawler = $this->client->followRedirect();
        $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());
        $this->assertGreaterThan(0, $crawler->filter('div:contains("L\'utilisateur a bien été modifié.")')->count());
    }

}