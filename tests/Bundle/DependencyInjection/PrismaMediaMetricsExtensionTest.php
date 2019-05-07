<?php

namespace PrismaMedia\Metrics\Tests\Bundle\DependencyInjection;

use PHPUnit\Framework\TestCase;
use PrismaMedia\Metrics\Bundle\Controller\MetricsController;
use PrismaMedia\Metrics\Bundle\DependencyInjection\PrismaMediaMetricsExtension;
use PrismaMedia\Metrics\Bundle\PrismaMediaMetricsBundle;
use PrismaMedia\Metrics\MetricAggregator;
use PrismaMedia\Metrics\MetricRenderer;
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
