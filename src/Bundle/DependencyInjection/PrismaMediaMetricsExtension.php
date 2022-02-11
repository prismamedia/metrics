<?php

declare(strict_types=1);

namespace PrismaMedia\Metrics\Bundle\DependencyInjection;

use PrismaMedia\Metrics\Bundle\PrismaMediaMetricsBundle;
use PrismaMedia\Metrics\MetricGenerator;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

class PrismaMediaMetricsExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $container->registerForAutoconfiguration(MetricGenerator::class)
            ->addTag(PrismaMediaMetricsBundle::TAG_METRIC);

        $loader = new PhpFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.php');
    }
}
