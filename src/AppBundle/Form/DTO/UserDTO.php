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
namespace AppBundle\Form\DTO;

use AppBundle\Form\DTO\Interfaces\UserDTOInterface;

/**
 * Class UserDTO.
 *
 * @author Laurent BERTON <lolosambo2@gmail.com>
 */
class UserDTO implements UserDTOInterface
{
    /**
     * @var string
     */
    public $username;
    /**
     * @var string
     */
    public $password;
    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $role;

    /**
     * UserDTO constructor.
     *
     * @param string $pseudo
     * @param string $password
     * @param string $mail
     */
    public function __construct(
        string $username = null,
        string $password = null,
        string $email = null,
        string $role = null
    ) {
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->role = $role;
    }
}
