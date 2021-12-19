<?php

namespace PrismaMedia\Metrics;

interface MetricGenerator
{
    /**
     * @return iterable<Metric>
     */
    public function getMetrics(): iterable;
}
