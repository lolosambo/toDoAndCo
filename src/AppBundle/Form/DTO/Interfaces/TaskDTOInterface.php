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
namespace AppBundle\Form\DTO\Interfaces;

/**
 * Interface UserDTOInterface.
 *
 * @author Laurent BERTON <lolosambo2@gmail.com>
 */
interface TaskDTOInterface
{
    /**
     * TaskDTOInterface constructor.
     *
     * @param string $title
     * @param string $content
     */
    public function __construct(
        string $title = null,
        string $content= null
    );
}
