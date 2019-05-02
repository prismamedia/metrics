<?php

namespace PrismaMedia\MetricsBundle;

interface MetricProvider
{
    /**
     * @return \Generator<Metric>
     */
    public function getMetrics();
}
