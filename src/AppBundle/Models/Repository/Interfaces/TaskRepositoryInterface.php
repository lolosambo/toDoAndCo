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
namespace AppBundle\Models\Repository\Interfaces;

use AppBundle\Models\Entity\Task;

/**
 * Interface TaskRepositoryInterface.
 *
 * @author Laurent BERTON <lolosambo2@gmail.com>
 */
interface TaskRepositoryInterface
{
    /**
     * @param int $taskId
     *
     * @return mixed
     */
    public function findTask(int $taskId);

    /**
     * @return array
     */
    public function findAllTasks(): array;

    /**
     * @param int $taskId
     */
    public function deleteTask(int $taskId);

    /**
     * @param $task
     */
    public function save($task): void;

    public function flush(): void;
}