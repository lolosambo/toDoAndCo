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

use AppBundle\Form\Handler\Interfaces\CreateUserHandlerInterface;
use AppBundle\Form\Type\UserType;
use AppBundle\Models\Repository\Interfaces\UserRepositoryInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Twig\Environment;

/**
 * @author Laurent BERTON <lolosambo2@gmail.com>
 *
 * Class CreateUserController
 */
class CreateUserController
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
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $passEncoder;


    /**
     * CreateUserController constructor.
     *
     * @param UserRepositoryInterface $
     * @param $taskRepository
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        Environment $twig,
        FormFactoryInterface $formFactory,
        UrlGeneratorInterface $urlGenerator,
        UserPasswordEncoderInterface $passEncoder
    ) {
        $this->userRepository = $userRepository;
        $this->twig = $twig;
        $this->formFactory = $formFactory;
        $this->urlGenerator = $urlGenerator;
        $this->passEncoder = $passEncoder;
    }

    /**
     * @Route("/users/create", name="user_create")
     *
     * @param Request $request
     *
     * @return string
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function __invoke(
        Request $request,
        CreateUserHandlerInterface $handler
    ) {
        $form = $this->formFactory->create(UserType::class);
        $form->handleRequest($request);
        if ($handler->handle($form)) {
            $request->getSession()->getFlashBag()->add('success', "L'utilisateur a bien été ajouté. Vous pouvez maintenant vous connecter.");

            return new RedirectResponse($this->urlGenerator->generate('login'));
        }

        return new Response($this->twig->render('user/create.html.twig', ['form' => $form->createView()]));
    }
}