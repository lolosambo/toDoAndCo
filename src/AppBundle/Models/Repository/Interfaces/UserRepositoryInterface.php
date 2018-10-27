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
namespace AppBundle\Models\Repository\Interfaces;

use AppBundle\Models\Entity\User;

/**
 * Interface UserRepository.
 *
 * @author Laurent BERTON <lolosambo2@gmail.com>
 */
interface UserRepositoryInterface
{

    /**
     * @param int $id
     *
     * @return null|User
     */
    public function findUser(int $userId);

    /**
     * @param $user
     *
     */
    public function save($user): void;

    /**
     * @return mixed
     */
    public function flush(): void;
}