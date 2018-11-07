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
namespace AppBundle\Form\Handler;

use AppBundle\Form\Handler\Interfaces\EditTaskHandlerInterface;
use AppBundle\Models\Repository\Interfaces\TaskRepositoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class EditTaskHandler.
 *
 * @author Laurent BERTON <lolosambo2@gmail.com>
 */
class EditTaskHandler implements EditTaskHandlerInterface
{
    /**
     * @var TaskRepositoryInterface
     */
    private $taskRepository;

    /**
     * CreateTaskHandler constructor.
     *
     * @param TaskRepositoryInterface $tasksRepository
     */
    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    /**
     * @param Request $request
     * @param FormInterface $taskType
     *
     * @return bool|mixed
     *
     * @throws \Exception
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function handle(
        Request $request,
        FormInterface $taskType
    ) {
        if ($taskType->isSubmitted() && $taskType->isValid()) {
            $title = $taskType->getData()->title;
            $content = $taskType->getData()->content;
            $task = $this->taskRepository->findTask(intval($request->get('id')));
            $task->setTitle($title);
            $task->setContent($content);
            $this->taskRepository->flush();

            return true;
        }
        return false;
    }
}
