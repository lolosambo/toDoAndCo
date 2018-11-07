<?php
declare(strict_types=1);
/*
 * This file is part of the SnowTricks project.
 *
 * (c) Laurent BERTON <lolosambo2@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Tests\AppBundle\Form\DTO;

use AppBundle\Form\DTO\TaskDTO;
use PHPUnit\Framework\TestCase;

/**
 * Class TaskDTOTest
 *
 *  @author Laurent BERTON <lolosambo2@gmail.com>
 */
class TaskDTOTest extends TestCase
{
    /**
     * @var TaskDTO
     */
    private $dto;

    public function setUp()
    {
        $dto = new TaskDTO(
            'Test Title',
            'some content for the TaskTest'
        );
        $this->dto = $dto;
    }
    /**
     * @group unit
     *
     * @covers AppBundle\Form\DTO\TaskDTO
     */
    public function testTitleAttributeMustBeAString()
    {
        static::assertInternalType('string', $this->dto->title);
    }
    /**
     * @group unit
     *
     * @covers AppBundle\Form\DTO\TaskDTO
     */
    public function testContentAttributeMustBeAString()
    {
        static::assertInternalType('string', $this->dto->content);
    }
}
