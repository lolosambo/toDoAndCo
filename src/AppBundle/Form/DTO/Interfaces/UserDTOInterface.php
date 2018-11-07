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
namespace AppBundle\Form\DTO\Interfaces;

/**
 * Class UserDTOInterface.
 *
 * @author Laurent BERTON <lolosambo2@gmail.com>
 */
interface UserDTOInterface
{
    /**
     * UserDTOInterface constructor.
     *
     * @param string|null $username
     * @param string|null $password
     * @param string|null $email
     * @param string|null $role
     */
    public function __construct(
        string $username = null,
        string $password = null,
        string $email = null,
        string $role = null
    );
}
