<?php

namespace PrismaMedia\MetricsBundle;

/**
 * Adds static labels to the metrics.
 */
class MetricLabeller implements MetricProvider
{
    /**
     * @var MetricProvider
     */
    private $metricProvider;

    /**
     * @var array
     */
    private $labels;

    /**
     * @param \Traversable $metricProviders
     * @param array        $labels          Labels to append to the metric
     */
    public function __construct(MetricProvider $metricProvider, array $labels)
    {
        $this->metricProvider = $metricProvider;
        $this->labels = $labels;
    }

    /**
     * {@inheritdoc}
     */
    public function getMetrics()
    {
        /** @var Metric $metric */
        foreach ($this->metricProvider->getMetrics() as $metric) {
            yield new Metric(
                $metric->getName(),
                $metric->getValue(),
                array_replace($this->labels, $metric->getLabels())
            );
        }
    }
}
