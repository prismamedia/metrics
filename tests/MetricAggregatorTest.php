<?php

namespace PrismaMedia\Metrics\Tests;

use PHPUnit\Framework\TestCase;
use PrismaMedia\Metrics\Metric;
use PrismaMedia\Metrics\MetricAggregator;
use PrismaMedia\Metrics\MetricGenerator;

class MetricAggregatorTest extends TestCase
{
    public function testGetMetricsShouldMergeInjectedGenerators(): void
    {
        $metrics1 = new class() implements MetricGenerator {
            public function getMetrics(): iterable
            {
                yield new Metric('article_total', 42, ['brand' => 'capital']);
                yield new Metric('article_total', 876, ['brand' => 'femmeactuelle', 'env' => 'conflict']);
            }
        };

        $metrics2 = new class() implements MetricGenerator {
            public function getMetrics(): iterable
            {
                return new \ArrayIterator([new Metric('app_total', 983)]);
            }
        };

        $metrics3 = new class() implements MetricGenerator {
            public function getMetrics(): iterable
            {
                return [];
            }
        };

        $aggregator = new MetricAggregator(new \ArrayIterator([$metrics1, $metrics2, $metrics3]));

        $metrics = $aggregator->getMetrics();

        $this->assertInstanceOf(\Generator::class, $metrics);
        $this->assertCount(3, $metrics);
    }
}
