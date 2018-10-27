<?php

namespace AppBundle\Controller;

use AppBundle\Models\Repository\Interfaces\UserRepositoryInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Twig\Environment;

/**
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
    public function listAction()
    {
        return $this->twig->render('user/list.html.twig', ['users' => $this->userRepository->findAllUsers()]);
    }

}
