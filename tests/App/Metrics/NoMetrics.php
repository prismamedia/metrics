<?php

namespace PrismaMedia\MetricsBundle\Tests\App\Metrics;

use PrismaMedia\MetricsBundle\MetricGenerator;

class NoMetrics implements MetricGenerator
{
    /**
     * {@inheritdoc}
     */
    public function getMetrics(): \Generator
    {
        if (false) {
            yield;
        }
    }
}
