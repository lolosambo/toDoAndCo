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
namespace Tests;

use AppBundle\Models\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/**
 * Trait LoginTrait
 *
 * @author Laurent BERTON <lolosambo2@gmail.com>
 */
trait LoginTrait extends WebTestCase
{

    public function logInAs($username)
    {
        $session = $this->client->getContainer()->get('session');
        $firewallContext = 'main';
        $user = $this->client->getContainer()->get('doctrine')->getManager()->getRepository(User::class)->findOneByUsername($username);
        $token = new UsernamePasswordToken($user, $user->getPassword(), $firewallContext, $user->getRoles());
        $session->set('_security_' . $firewallContext, serialize($token));
        $session->save();
        return $user;
    }
}