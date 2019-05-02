<?php

namespace PrismaMedia\MetricsBundle\Tests;

use PHPUnit\Framework\TestCase;
use PrismaMedia\MetricsBundle\Controller\MetricsController;
use PrismaMedia\MetricsBundle\DependencyInjection\PrismaMediaMetricsExtension;
use PrismaMedia\MetricsBundle\MetricAggregator;
use PrismaMedia\MetricsBundle\MetricRenderer;
use PrismaMedia\MetricsBundle\PrismaMediaMetricsBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;

class PrismaMediaMetricsExtensionTest extends TestCase
{
    public function testLoadWithoutConfiguration()
    {
        $container = $this->createContainer();
        $container->registerExtension(new PrismaMediaMetricsExtension());
        $container->loadFromExtension('prisma_media_metrics', []);
        $this->compileContainer($container);

        $this->assertSame(MetricAggregator::class, $container->getDefinition(MetricAggregator::class)->getClass());
        $this->assertSame(MetricsController::class, $container->getDefinition(MetricsController::class)->getClass());
        $this->assertSame(MetricRenderer::class, $container->getDefinition(MetricRenderer::class)->getClass());
    }

    private function createContainer()
    {
        $container = new ContainerBuilder(new ParameterBag([
            'kernel.cache_dir' => __DIR__,
            'kernel.charset' => 'UTF-8',
            'kernel.debug' => true,
            'kernel.bundles' => ['PrismaMediaMetricsBundle' => PrismaMediaMetricsBundle::class],
        ]));

        return $container;
    }

    private function compileContainer(ContainerBuilder $container)
    {
        $container->getCompilerPassConfig()->setOptimizationPasses([]);
        $container->getCompilerPassConfig()->setRemovingPasses([]);
        $container->compile();
    }
}
