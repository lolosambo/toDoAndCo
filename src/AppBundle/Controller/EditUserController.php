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

use AppBundle\Form\Handler\Interfaces\EditUserHandlerInterface;
use AppBundle\Form\Type\UserType;
use AppBundle\Models\Entity\User;
use AppBundle\Models\Repository\Interfaces\UserRepositoryInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Twig\Environment;

/**
 * @author Laurent BERTON <lolosambo2@gmail.com>
 *
 * Class EditUserController
 */
class EditUserController
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
     * @var TokenStorageInterface
     */
    private $token;

    /**
     * EditUserController constructor.
     *
     * @param UserRepositoryInterface $userRepository
     * @param Environment $twig
     * @param FormFactoryInterface $formFactory
     * @param UrlGeneratorInterface $urlGenerator
     * @param UserPasswordEncoderInterface $passEncoder
     * @param TokenStorageInterface $token
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        Environment $twig,
        FormFactoryInterface $formFactory,
        UrlGeneratorInterface $urlGenerator,
        UserPasswordEncoderInterface $passEncoder,
        TokenStorageInterface $token
    ) {
        $this->userRepository = $userRepository;
        $this->twig = $twig;
        $this->formFactory = $formFactory;
        $this->urlGenerator = $urlGenerator;
        $this->passEncoder = $passEncoder;
        $this->token = $token;
    }

    /**
     * @Route("/users/{id}/edit", name="user_edit")
     *
     * @param Request $request
     * @param EditUserHandlerInterface $handler
     *
     * @return RedirectResponse|Response
     *
     * @throws \Exception
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function __invoke(
        Request $request,
        EditUserHandlerInterface $handler
    ) {
        $this->token->getToken()->getUser();
        if(($this->token->getToken()->getUser() === "anon.") || ($this->token->getToken()->getUser()->getRole() === "ROLE_USER")){
            return new RedirectResponse($this->urlGenerator->generate('login'));
        }
        $user = $this->userRepository->findUser(intval($request->get('id')));
        $form = $this->formFactory->create(UserType::class)->handleRequest($request);

        if ($handler->handle($request, $form)) {
            $request->getSession()->getFlashbag()->add('success', "L'utilisateur a bien été modifié");

            return new RedirectResponse($this->urlGenerator->generate('user_list'));
        }
            return new Response($this->twig->render('user/edit.html.twig', [
                'form' => $form->createView(),
                'user' => $user
            ]));
    }
}