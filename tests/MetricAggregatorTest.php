<?php

namespace PrismaMedia\MetricsBundle\Tests;

use PHPUnit\Framework\TestCase;
use PrismaMedia\MetricsBundle\Metric;
use PrismaMedia\MetricsBundle\MetricAggregator;
use PrismaMedia\MetricsBundle\MetricProvider;

class MetricAggregatorTest extends TestCase
{
    public function testGetMetrics()
    {
        $metrics1 = new class() implements MetricProvider {
            public function getMetrics()
            {
                yield new Metric('article_total', 42, ['brand' => 'capital']);
                yield new Metric('article_total', 876, ['brand' => 'femmeactuelle', 'env' => 'conflict']);
            }
        };

        $metrics2 = new class() implements MetricProvider {
            public function getMetrics()
            {
                yield new Metric('app_total', 983);
            }
        };

        $metrics3 = new class() implements MetricProvider {
            public function getMetrics()
            {
                if (false) {
                    yield;
                }
            }
        };

        $aggregator = new MetricAggregator(new \ArrayIterator([$metrics1, $metrics2, $metrics3]));

        $metrics = $aggregator->getMetrics();

        $this->assertInstanceOf('Generator', $metrics);
        $this->assertCount(3, $metrics);
    }
}
