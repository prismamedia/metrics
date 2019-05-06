<?php

namespace PrismaMedia\MetricsBundle;

interface MetricGenerator
{
    /**
     * @return \Generator<Metric>
     */
    public function getMetrics(): \Generator;
}
