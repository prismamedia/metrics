<?php

declare(strict_types=1);

namespace PrismaMedia\Metrics\Tests\Bundle\App\Metrics;

use PrismaMedia\Metrics\MetricGenerator;

class NoMetrics implements MetricGenerator
{
    public function getMetrics(): iterable
    {
        return [];
    }
}
