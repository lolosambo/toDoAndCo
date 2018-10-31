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
namespace AppBundle\Form\Handler\Interfaces;

use Symfony\Component\Form\FormInterface;

/**
 * Class CreateUserHandlerInterface.
 *
 * @author Laurent BERTON <lolosambo2@gmail.com>
 */
interface CreateUserHandlerInterface
{
    /**
     * @param FormInterface $userType
     *
     * @return bool|mixed
     *
     * @throws \Exception
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function handle(FormInterface $userType);
}