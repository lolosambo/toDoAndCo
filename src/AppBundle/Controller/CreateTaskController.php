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

use AppBundle\Form\Handler\Interfaces\CreateTaskHandlerInterface;
use AppBundle\Form\Type\TaskType;
use AppBundle\Models\Repository\Interfaces\TaskRepositoryInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Twig\Environment;

/**
 * @author Laurent BERTON <lolosambo2@gmail.com>
 *
 * Class CreateTaskController
 */
class CreateTaskController
{
    /**
     * @var TaskRepositoryInterface
     */
    private $taskRepository;

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
     * @var TokenStorageInterface
     */
    private $token;

    /**
     * TaskController constructor.
     *
     * @param TaskRepositoryInterface $
     * @param $taskRepository
     */
    public function __construct(
        TaskRepositoryInterface $taskRepository,
        Environment $twig,
        FormFactoryInterface $formFactory,
        UrlGeneratorInterface $urlGenerator,
        TokenStorageInterface $token
    ) {
        $this->taskRepository = $taskRepository;
        $this->twig = $twig;
        $this->formFactory = $formFactory;
        $this->urlGenerator = $urlGenerator;
        $this->token = $token;
    }

    /**
     * @Route("/tasks/create", name="task_create")
     *
     * @param Request $request
     * @param string $title
     * @param string $content
     *
     * @return string
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function __invoke(
        Request $request,
        CreateTaskHandlerInterface $handler
    ) {
        $this->token->getToken()->getUser();
        if ($this->token->getToken()->getUser() !== "anon.") {
            $form = $this->formFactory->create(TaskType::class);
            $form->handleRequest($request);
            if ($handler->handle($form)) {
                $request->getSession()->getFlashBag()->add('success', 'La tâche a été bien été ajoutée.');

                return new RedirectResponse($this->urlGenerator->generate('task_list'));
            }

            return new Response($this->twig->render('task/create.html.twig', ['form' => $form->createView()]));
        }
        $request->getSession()->getFlashBag()->add('error', "Petit malin ! Vous ne pouvez pas créer de tâche sans être authentifié !");
        return new RedirectResponse($this->urlGenerator->generate('login'));
    }
}
