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
use Symfony\Component\HttpFoundation\Response;
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
     * IndexController constructor.
     *
     * @param Environment $twig
     */
    public function __construct(
        TokenStorageInterface $token,
        Environment $twig
    ) {
        $this->token = $token;
        $this->twig = $twig;
    }

    /**
     * @Route("/", name="homepage")
     *
     * @return string
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function __invoke()
    {
        return new Response($this->twig->render('default/index.html.twig'));
    }
}