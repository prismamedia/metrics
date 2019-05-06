<?php

namespace PrismaMedia\MetricsBundle;

/**
 * Class MetricAggregator.
 */
class MetricAggregator implements MetricGenerator
{
    /**
     * @var MetricGenerator[]
     */
    private $metricGenerators;

    /**
     * @param \Traversable $metricGenerators
     */
    public function __construct(\Traversable $metricGenerators)
    {
        $this->metricGenerators = $metricGenerators;
    }

    /**
     * {@inheritdoc}
     */
    public function getMetrics(): \Generator
    {
        foreach ($this->metricGenerators as $metricProvider) {
            yield from $metricProvider->getMetrics();
        }
    }
}
