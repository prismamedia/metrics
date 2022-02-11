<?php

declare(strict_types=1);

namespace PrismaMedia\Metrics;

interface MetricGenerator
{
    /**
     * @return iterable<Metric>
     */
    public function getMetrics(): iterable;
}
