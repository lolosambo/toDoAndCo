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
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
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
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * @var TokenStorageInterface
     */
    private $token;

    /**
     * ShowAllUsersController constructor.
     *
     * @param UserRepositoryInterface $userRepository
     * @param TokenStorageInterface $token
     * @param Environment $twig
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        TokenStorageInterface $token,
        UrlGeneratorInterface $urlGenerator,
        Environment $twig
    ) {
        $this->userRepository = $userRepository;
        $this->twig = $twig;
        $this->urlGenerator = $urlGenerator;
        $this->token = $token;
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
    public function __invoke(Request $request)
    {
        $this->token->getToken()->getUser();
        if (($this->token->getToken()->getUser() === "anon.") || ($this->token->getToken()->getUser()->getRole() !== "ROLE_ADMIN")) {
            $request->getSession()->getFlashBag()->add('error', "Petit malin ! Vous n'avez pas accès à cette fonction !");
            return new RedirectResponse($this->urlGenerator->generate('login'));
        }
        $response = new Response($this->twig->render(
            'user/list.html.twig',
            [
            'users' => $this->userRepository->findAllUsers()
            ]
        ));
        $response->setEtag(md5($response->getContent()));
        $response->setPublic();
        if ($response->isNotModified($request)) {
            return $response;
        }
        return $response;
    }
}
