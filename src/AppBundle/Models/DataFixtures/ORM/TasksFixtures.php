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

use AppBundle\Models\Entity\Task;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class TasksFixtures
 *
 * @author Laurent BERTON <lolosambo2@gmail.com>
 */
class TasksFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $content = [
            'Cette tâche a été rédigée par un administrateur',
            'Cette tâche a été rédigée par un utilisateur',
            'Cette tâche a été rédigée par un anonyme'
        ];

        $users = ['AnonymousUser', 'toDoUser', 'toDoAdmin'];

        for($i=1; $i<21; ++$i) {
            $user = $this->getReference($users[array_rand($users)]);
            $title = 'Tâche N°'.$i;
            if($user->getUserName() === 'AnonymousUser') {
                $savedContent = $content[2];
            } elseif ($user->getUserName() === 'toDoUser') {
                $savedContent = $content[1];
            }else {
                $savedContent = $content[0];
            }
            $task = new Task($title, $savedContent );
            $task->setUser($user);
            $task->toggle(0);

            $manager->persist($task);
        }
        $manager->flush();
    }

    /**
     * @return array
     */
    public function getDependencies()
    {
        return [
            UsersFixtures::class
        ];
    }
}