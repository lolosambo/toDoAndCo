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
namespace AppBundle\Models\Repository;

use AppBundle\Models\Entity\Task;
use AppBundle\Models\Repository\Interfaces\TaskRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class TaskRepository.
 *
 * @author Laurent BERTON <lolosambo2@gmail.com>
 */
class TaskRepository extends ServiceEntityRepository implements TaskRepositoryInterface
{
    /**
     * TaskRepository constructor.
     *
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Task::class);
    }

    /**
     * @param int $taskId
     *
     * @return mixed
     *
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findTask(int $taskId)
    {
        return $this->createQueryBuilder('t')
            ->where('t.id = ?1')
            ->setParameter(1, $taskId)
            ->setCacheable(true)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @return array
     */
    public function findAllTasks(): array
    {
        return $this->createQueryBuilder('t')
            ->setCacheable(true)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param int $taskId
     */
    public function deleteTask(int $taskId)
    {
        return $this->createQueryBuilder('t')
            ->delete()
            ->where('t.id = ?1')
            ->setParameter(1, $taskId)
            ->setCacheable(true)
            ->getQuery()
            ->execute();
    }

    /**
     * @param $task
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save($task): void
    {
        $this->getEntityManager()->persist($task);
        $this->getEntityManager()->flush();
    }

    /**
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function flush(): void
    {
        $this->getEntityManager()->flush();
    }
}