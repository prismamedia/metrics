<?php

namespace PrismaMedia\Metrics\Tests\Bundle\App\Metrics;

use PrismaMedia\Metrics\MetricGenerator;

class NoMetrics implements MetricGenerator
{
    public function getMetrics(): \Traversable
    {
        if (false) {
            yield;
        }
    }
}
