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

use AppBundle\Models\Repository\Interfaces\TaskRepositoryInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

/**
 * @author Laurent BERTON <lolosambo2@gmail.com>
 *
 * Class ShowAllTasksController
 */
class ShowAllTasksController
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
     * TaskController constructor.
     *
     * @param TaskRepositoryInterface $
     * @param $taskRepository
     */
    public function __construct(
        TaskRepositoryInterface $taskRepository,
        Environment $twig
    ) {
        $this->taskRepository = $taskRepository;
        $this->twig = $twig;
    }

    /**
     * @Route("/tasks", name="task_list")
     *
     * @param Request $request
     *
     * @return Response
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function __invoke(Request $request)
    {
        $response = new Response($this->twig->render('task/list.html.twig', ['tasks' => $this->taskRepository->findAllTasks()]));
        $response->setEtag(md5($response->getContent()));
        $response->setPublic();
        if($response->isNotModified($request)) {
            return $response;
        }
        return $response;
    }

}
