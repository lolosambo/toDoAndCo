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

use AppBundle\Models\Entity\Task;
use AppBundle\Models\Repository\Interfaces\TaskRepositoryInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * @author Laurent BERTON <lolosambo2@gmail.com>
 *
 * Class ToggleTaskController
 */
class ToggleTaskController
{
    /**
     * @var TaskRepositoryInterface
     */
    private $taskRepository;

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
        UrlGeneratorInterface $urlGenerator
    ) {
        $this->taskRepository = $taskRepository;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @Route("/tasks/{id}/toggle", name="task_toggle")
     *
     * @param Task $task
     * @param Request $request
     *
     * @return string
     */
    public function __invoke(
        Task $task,
        Request $request
    ) {
        $task->toggle(!$task->isDone());
        $this->taskRepository->save($task);
        $request->getSession()->getFlashBag()->add('success', sprintf('La tâche %s a bien été marquée comme faite.', $task->getTitle()));

        return new RedirectResponse($this->urlGenerator->generate('task_list'));
    }
}