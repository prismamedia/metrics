<?php

namespace PrismaMedia\MetricsBundle\Tests;

use PHPUnit\Framework\TestCase;
use PrismaMedia\MetricsBundle\Metric;

class MetricTest extends TestCase
{
    public function testGetName()
    {
        $metric = new Metric('test_total', 100);
        $this->assertEquals(100, $metric->getValue());
    }

    public function testGetValue()
    {
        $metric = new Metric('test_total', 100);
        $this->assertEquals('test_total', $metric->getName());
    }

    public function testGetLabels()
    {
        $metric = new Metric('test_total', 100, ['brand' => 'capital', 'env' => 'staging']);
        $this->assertEquals(['brand' => 'capital', 'env' => 'staging'], $metric->getLabels());
        $this->assertTrue($metric->hasLabels());
    }

    public function testGetLabelsEmpty()
    {
        $metric = new Metric('test_total', 100);
        $this->assertEquals([], $metric->getLabels());
        $this->assertFalse($metric->hasLabels());
    }
}
