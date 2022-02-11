<?php

declare(strict_types=1);

namespace PrismaMedia\Metrics\Tests;

use PHPUnit\Framework\TestCase;
use PrismaMedia\Metrics\Metric;

class MetricTest extends TestCase
{
    public function testGetName(): void
    {
        $metric = new Metric('test_total', 100);
        $this->assertEquals(100, $metric->getValue());
    }

    public function testGetValue(): void
    {
        $metric = new Metric('test_total', 100);
        $this->assertEquals('test_total', $metric->getName());
    }

    public function testGetLabels(): void
    {
        $metric = new Metric('test_total', 100, ['brand' => 'capital', 'env' => 'staging']);
        $this->assertEquals(['brand' => 'capital', 'env' => 'staging'], $metric->getLabels());
        $this->assertTrue($metric->hasLabels());
    }

    public function testGetLabelsEmpty(): void
    {
        $metric = new Metric('test_total', 100);
        $this->assertEquals([], $metric->getLabels());
        $this->assertFalse($metric->hasLabels());
    }
}
