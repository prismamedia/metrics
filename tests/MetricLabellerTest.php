<?php

namespace PrismaMedia\MetricsBundle\Tests;

use PHPUnit\Framework\TestCase;
use PrismaMedia\MetricsBundle\Metric;
use PrismaMedia\MetricsBundle\MetricLabeller;
use PrismaMedia\MetricsBundle\MetricProvider;

class MetricLabellerTest extends TestCase
{
    public function test_it_should_add_static_labels()
    {
        $metrics = new class() implements MetricProvider {
            public function getMetrics()
            {
                yield new Metric('article_total', 42, ['brand' => 'capital']);
                yield new Metric('article_total', 876, ['env' => 'conflict', 'brand' => 'femmeactuelle']);
                yield new Metric('app_total', 983);
            }
        };

        $labeller = new MetricLabeller($metrics, ['env' => 'staging']);

        $this->assertInstanceOf('Generator', $labeller->getMetrics());
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

    public function test_it_should_accept_empty_metrics()
    {
        $metrics = new class() implements MetricProvider {
            public function getMetrics()
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
