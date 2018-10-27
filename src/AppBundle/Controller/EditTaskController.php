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

use AppBundle\Form\Handler\Interfaces\EditTaskHandlerInterface;
use AppBundle\Form\Type\TaskType;
use AppBundle\Models\Entity\Task;
use AppBundle\Models\Repository\Interfaces\TaskRepositoryInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

/**
 * @author Laurent BERTON <lolosambo2@gmail.com>
 *
 * Class EditTaskController
 */
class EditTaskController
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
     * TaskController constructor.
     *
     * @param TaskRepositoryInterface $
     * @param $taskRepository
     */
    public function __construct(
        TaskRepositoryInterface $taskRepository,
        Environment $twig,
        FormFactoryInterface $formFactory,
        UrlGeneratorInterface $urlGenerator
    ) {
        $this->taskRepository = $taskRepository;
        $this->twig = $twig;
        $this->formFactory = $formFactory;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @Route("/tasks/{id}/edit", name="task_edit")
     *
     * @param Request $request
     * @param EditTaskHandlerInterface $handler
     *
     * @return RedirectResponse|Response
     *
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function __invoke(
        Request $request,
        EditTaskHandlerInterface $handler
    ) {
        $task = $this->taskRepository->findTask(intval($request->attributes->get('id')));
        $form = $this->formFactory->create(TaskType::class);
        $form->handleRequest($request);
        if ($handler->handle($request, $form)) {
            $request->getSession()->getFlashBag()->add('success', 'La tâche a bien été modifiée.');

            return new RedirectResponse($this->urlGenerator->generate('task_list'));
        }

        return new Response($this->twig->render('task/edit.html.twig', [
            'form' => $form->createView(),
            'task' => $task,
        ]));
    }
}