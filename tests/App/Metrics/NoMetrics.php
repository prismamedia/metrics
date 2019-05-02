<?php

namespace PrismaMedia\MetricsBundle\Tests\App\Metrics;

use PrismaMedia\MetricsBundle\MetricProvider;

class NoMetrics implements MetricProvider
{
    /**
     * {@inheritdoc}
     */
    public function getMetrics()
    {
        if (false) {
            yield;
        }
    }
}
