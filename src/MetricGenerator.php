<?php

namespace PrismaMedia\Metrics;

interface MetricGenerator
{
    /**
     * @return \Traversable<Metric>
     */
    public function getMetrics(): \Traversable;
}
