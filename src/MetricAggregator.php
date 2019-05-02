<?php

namespace PrismaMedia\MetricsBundle;

class MetricAggregator implements MetricProvider
{
    /**
     * @var MetricProvider[]
     */
    private $metricProviders;

    /**
     * @param \Traversable $metricProviders
     */
    public function __construct(\Traversable $metricProviders)
    {
        $this->metricProviders = $metricProviders;
    }

    /**
     * {@inheritdoc}
     */
    public function getMetrics()
    {
        foreach ($this->metricProviders as $metricProvider) {
            foreach ($metricProvider->getMetrics() as $metric) {
                yield $metric;
            }
        }
    }
}
