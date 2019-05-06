<?php

namespace PrismaMedia\MetricsBundle;

class MetricRenderer
{
    /**
     * @param Metric $metric
     *
     * @return string
     */
    public function render(Metric $metric): string
    {
        $labels = '';
        if ($metric->hasLabels()) {
            $labels = sprintf('{%s}', implode(',', array_map(function ($key, $value) {
                return sprintf('%s="%s"', $key, $value);
            }, array_keys($metric->getLabels()), $metric->getLabels())));
        }

        return sprintf("%s%s %s\r\n", $metric->getName(), $labels, $metric->getValue());
    }
}
