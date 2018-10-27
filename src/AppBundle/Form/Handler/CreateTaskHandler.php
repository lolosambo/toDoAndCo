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

use AppBundle\Form\Handler\Interfaces\CreateTaskHandlerInterface;
use AppBundle\Models\Entity\Task;
use AppBundle\Models\Entity\User;
use AppBundle\Models\Repository\Interfaces\TaskRepositoryInterface;
use AppBundle\Models\Repository\Interfaces\UserRepositoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Csrf\TokenStorage\TokenStorageInterface;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class CreateTaskHandler.
 *
 * @author Laurent BERTON <lolosambo2@gmail.com>
 */
class CreateTaskHandler implements CreateTaskHandlerInterface
{
    /**
     * @var TaskRepositoryInterface
     */
    private $taskRepository;

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var Security
     */
    private $security;

    /**
     * CreateTaskHandler constructor.
     *
     * @param TaskRepositoryInterface $taskRepository
     * @param TokenStorageInterface $tokenStorage
     * @param Security $security
     */
    public function __construct(
        TaskRepositoryInterface $taskRepository,
        TokenStorageInterface $tokenStorage,
        Security $security
    ) {
        $this->taskRepository = $taskRepository;
        $this->tokenStorage = $tokenStorage;
        $this->security = $security;
    }

    /**
     * @param Request $request
     * @param FormInterface $taskType
     * @return bool|mixed
     */
    public function handle(
        Request $request,
        FormInterface $taskType
    ) {
        if ($taskType->isSubmitted() && $taskType->isValid()) {
            $title = $taskType->getData()->title;
            $content = $taskType->getData()->content;
            $user = $this->security->getUser();
            $task = new Task($title, $content);
            $task->setUser($user);
            $this->taskRepository->save($task);
            return true;
        }
        return false;
    }
}