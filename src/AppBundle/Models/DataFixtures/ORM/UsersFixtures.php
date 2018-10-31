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
namespace AppBundle\Models\DataFixtures\ORM;

use AppBundle\Models\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class UsersFixtures
 *
 * @author Laurent BERTON <lolosambo2@gmail.com>
 */
class UsersFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $username = 'AnonymousUser';
        $password = '$2y$13$aj.tJ0NNFEab1cIGhFUepeU5CBlz/GhdbO9XLuE33QuJJZRKL9Y3C';
        $email = 'anonymous@todoandco.com';
        $role = "ROLE_USER";
        $user = new User($username, $password, $email, $role);
        $this->addReference('AnonymousUser', $user );
        $manager->persist($user);

        $username = 'toDoUser';
        $password = '$2y$13$aj.tJ0NNFEab1cIGhFUepeU5CBlz/GhdbO9XLuE33QuJJZRKL9Y3C';
        $email = 'toDoUser@todoandco.com';
        $role = "ROLE_USER";
        $user = new User($username, $password, $email, $role);
        $this->addReference('toDoUser', $user );
        $manager->persist($user);

        $username = 'toDoAdmin';
        $password = '$2y$13$aj.tJ0NNFEab1cIGhFUepeU5CBlz/GhdbO9XLuE33QuJJZRKL9Y3C';
        $email = 'admin2@todoandco.com';
        $role = "ROLE_ADMIN";
        $user = new User($username, $password, $email, $role);
        $this->addReference('toDoAdmin', $user );
        $manager->persist($user);

        $manager->flush();
    }
}