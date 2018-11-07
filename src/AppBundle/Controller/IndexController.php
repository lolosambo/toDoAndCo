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

use AppBundle\Models\Entity\User;
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
 * Class IndexController
 */
class IndexController
{

    /**
     * @var Environment
     */
    private $twig;

    /**
     * @var TokenStorageInterface
     */
    private $token;

    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * IndexController constructor.
     *
     * @param Environment $twig
     */
    public function __construct(
        TokenStorageInterface $token,
        Environment $twig,
        UrlGeneratorInterface $urlGenerator
    ) {
        $this->token = $token;
        $this->twig = $twig;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @Route("/", name="homepage")
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function __invoke(Request $request)
    {
        $this->token->getToken()->getUser();
        if ($this->token->getToken()->getUser() === "anon.") {
            return new RedirectResponse($this->urlGenerator->generate('login'));
        }
        $response = new Response($this->twig->render('default/index.html.twig'));
        $response->setEtag(md5($response->getContent()));
        $response->setPublic();
        if ($response->isNotModified($request)) {
            return $response;
        }
        return $response;
    }
}
