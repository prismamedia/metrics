<?php

declare(strict_types=1);

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

    public function __construct(iterable $metricGenerators)
    {
        $this->metricGenerators = $metricGenerators;
    }

    /**
     * {@inheritdoc}
     */
    public function getMetrics(): iterable
    {
        foreach ($this->metricGenerators as $metricProvider) {
            if ($metricProvider === $this) {
                throw new \InvalidArgumentException('Cyclic dependency detected.');
            }

            yield from $metricProvider->getMetrics();
        }
    }
}
