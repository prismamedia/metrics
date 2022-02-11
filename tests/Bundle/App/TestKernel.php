<?php

declare(strict_types=1);

namespace PrismaMedia\Metrics\Tests\Bundle\App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel;

/**
 * Kernel for functional tests.
 */
class TestKernel extends Kernel
{
    use MicroKernelTrait;

    public function getProjectDir(): string
    {
        return __DIR__;
    }
}
