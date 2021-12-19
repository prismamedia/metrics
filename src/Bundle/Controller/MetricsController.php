<?php

namespace PrismaMedia\Metrics\Bundle\Controller;

use PrismaMedia\Metrics\MetricGenerator;
use PrismaMedia\Metrics\MetricRenderer;
use Symfony\Component\HttpFoundation\StreamedResponse;

final class MetricsController
{
    private MetricGenerator $metrics;
    private MetricRenderer $metricRenderer;

    public function __construct(MetricGenerator $metrics, MetricRenderer $metricRenderer)
    {
        $this->metrics = $metrics;
        $this->metricRenderer = $metricRenderer;
    }

    public function __invoke(): StreamedResponse
    {
        $response = new StreamedResponse();
        $response->headers->set('Content-Type', 'text/plain; charset=utf-8');

        // No cache
        $response->setPrivate();
        $response->headers->addCacheControlDirective('no-cache');
        $response->headers->addCacheControlDirective('no-store');

        $response->setCallback(function () {
            foreach ($this->metrics->getMetrics() as $metric) {
                echo $this->metricRenderer->render($metric);
            }
        });

        return $response;
    }
}
