<?php

declare(strict_types=1);

namespace PrismaMedia\Metrics;

use function sprintf;

class MetricRenderer
{
    public function render(Metric $metric): string
    {
        $labels = '';
        if ($metric->hasLabels()) {
            $labels = sprintf('{%s}', implode(',', array_map(function ($key, $value) {
                return sprintf('%s="%s"', $key, $value);
            }, array_keys($metric->getLabels()), $metric->getLabels())));
        }

        return sprintf("%s%s %s \n", $metric->getName(), $labels, $metric->getValue());
    }
}
