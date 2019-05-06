<?php

namespace PrismaMedia\MetricsBundle\Tests\App\Metrics;

use PrismaMedia\MetricsBundle\Metric;
use PrismaMedia\MetricsBundle\MetricGenerator;

class ArticleMetrics implements MetricGenerator
{
    /**
     * {@inheritdoc}
     */
    public function getMetrics(): \Generator
    {
        yield new Metric('article_total', 42, ['brand' => 'Capital']);
        yield new Metric('article_total', 876, ['brand' => 'Femme Actuelle']);
        yield new Metric('article_total', 381, ['brand' => 'Télé-Loisirs']);
    }
}
