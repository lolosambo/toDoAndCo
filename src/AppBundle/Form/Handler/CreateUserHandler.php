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
namespace AppBundle\Form\Handler;

use AppBundle\Form\Handler\Interfaces\CreateUserHandlerInterface;
use AppBundle\Models\Entity\User;
use AppBundle\Models\Repository\Interfaces\UserRepositoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class CreateUserHandler.
 *
 * @author Laurent BERTON <lolosambo2@gmail.com>
 */
class CreateUserHandler implements CreateUserHandlerInterface
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * CreateUserHandler constructor.
     *
     * @param UserRepositoryInterface $usersRepository
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        UserPasswordEncoderInterface $passwordEncoder
    ) {
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @param Request $request
     * @param FormInterface $userType
     *
     * @return bool|mixed
     *
     * @throws \Exception
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function handle(
        Request $request,
        FormInterface $userType
    ) {
        if ($userType->isSubmitted() && $userType->isValid()) {
            $username = $userType->getData()->username;
            $email = $userType->getData()->email;
            $password = $userType->getData()->password;
            $role = $userType->getData()->role;
            $user = new User(
                $username,
                $password,
                $email,
                $role
            );
            $password = $this->passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $this->userRepository->save($user);

            return true;
        }
        return false;
    }
}