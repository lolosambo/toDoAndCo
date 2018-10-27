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

namespace AppBundle\Controller;

use AppBundle\Models\Repository\Interfaces\UserRepositoryInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

/**
 * @author Laurent BERTON <lolosambo2@gmail.com>
 *
 * Class ShowAllUsersController
 */
class ShowAllUsersController
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var Environment
     */
    private $twig;

    /**
     * ShowAllUsersController constructor.
     *
     * @param UserRepositoryInterface $userRepository
     * @param Environment $twig
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        Environment $twig
    )
    {
        $this->userRepository = $userRepository;
        $this->twig = $twig;
    }

    /**
     * @Route("/users", name="user_list")
     *
     * @return string
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function __invoke()
    {
        return new Response($this->twig->render('user/list.html.twig', ['users' => $this->userRepository->findAllUsers()]));
    }

}
