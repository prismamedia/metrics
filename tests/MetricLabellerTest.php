<?php

namespace PrismaMedia\Metrics\Tests;

use PHPUnit\Framework\TestCase;
use PrismaMedia\Metrics\Metric;
use PrismaMedia\Metrics\MetricGenerator;
use PrismaMedia\Metrics\MetricLabeller;

class MetricLabellerTest extends TestCase
{
    public function testGetMetricsShouldAddStaticLabels(): void
    {
        $metrics = new class() implements MetricGenerator {
            public function getMetrics(): \Traversable
            {
                yield new Metric('article_total', 42, ['brand' => 'capital']);
                yield new Metric('article_total', 876, ['env' => 'conflict', 'brand' => 'femmeactuelle']);
                yield new Metric('app_total', 983);
            }
        };

        $labeller = new MetricLabeller($metrics, ['env' => 'staging']);

        $this->assertInstanceOf(\Generator::class, $labeller->getMetrics());
        $this->assertCount(3, $labeller->getMetrics());
        $metrics = iterator_to_array($labeller->getMetrics());

        $this->assertSame('article_total', $metrics[0]->getName());
        $this->assertSame('article_total', $metrics[1]->getName());
        $this->assertSame('app_total', $metrics[2]->getName());
        $this->assertSame(42, $metrics[0]->getValue());
        $this->assertSame(876, $metrics[1]->getValue());
        $this->assertSame(983, $metrics[2]->getValue());
        $this->assertSame(['env' => 'staging', 'brand' => 'capital'], $metrics[0]->getLabels());
        $this->assertSame(['env' => 'conflict', 'brand' => 'femmeactuelle'], $metrics[1]->getLabels());
        $this->assertSame(['env' => 'staging'], $metrics[2]->getLabels());
    }

    public function testGetMetricsShouldAcceptEmptyGenerator(): void
    {
        $metrics = new class() implements MetricGenerator {
            public function getMetrics(): \Traversable
            {
                if (false) {
                    yield;
                }
            }
        };

        $labeller = new MetricLabeller($metrics, ['env' => 'staging']);

        $metrics = iterator_to_array($labeller->getMetrics());

        $this->assertCount(0, $metrics);
    }
}
