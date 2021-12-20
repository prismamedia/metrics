<?php

namespace PrismaMedia\Metrics\Bundle\Controller;

use PrismaMedia\Metrics\MetricGenerator;
use PrismaMedia\Metrics\MetricRenderer;
use Symfony\Component\HttpFoundation\Response;

final class MetricsController
{
    private MetricGenerator $metrics;
    private MetricRenderer $metricRenderer;

    public function __construct(MetricGenerator $metrics, MetricRenderer $metricRenderer)
    {
        $this->metrics = $metrics;
        $this->metricRenderer = $metricRenderer;
    }

    public function __invoke(): Response
    {
        $content = '';
        foreach ($this->metrics->getMetrics() as $metric) {
            $content .= $this->metricRenderer->render($metric);
        }

        return new Response($content, 200, [
            'Content-Type' => 'text/plain; charset=utf-8',
            'Cache-Control' => 'private, no-cache, no-store',
        ]);
    }
}
