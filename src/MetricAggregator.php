<?php

namespace PrismaMedia\Metrics;

/**
 * Aggregate metrics from multiple generators.
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
    public function getMetrics(): \Traversable
    {
        foreach ($this->metricGenerators as $metricProvider) {
            yield from $metricProvider->getMetrics();
        }
    }
}
