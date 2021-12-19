<?php

namespace PrismaMedia\Metrics\Tests\Bundle\App\Metrics;

use PrismaMedia\Metrics\Metric;
use PrismaMedia\Metrics\MetricGenerator;

class ArticleMetrics implements MetricGenerator
{
    public function getMetrics(): iterable
    {
        yield new Metric('article_total', 42, ['brand' => 'Capital']);
        yield new Metric('article_total', 876, ['brand' => 'Femme Actuelle']);
        yield new Metric('article_total', 381, ['brand' => 'Télé-Loisirs']);
    }
}
