<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use PrismaMedia\Metrics\Bundle\Controller\MetricsController;
use PrismaMedia\Metrics\Bundle\PrismaMediaMetricsBundle;
use PrismaMedia\Metrics\MetricAggregator;
use PrismaMedia\Metrics\MetricRenderer;

return function (ContainerConfigurator $configurator) {
    $configurator->services()
        ->set(MetricAggregator::class)
            ->args([tagged_iterator(PrismaMediaMetricsBundle::TAG_METRIC)])

        ->set(MetricRenderer::class)

        ->set(MetricsController::class)
            ->args([service(MetricAggregator::class), service(MetricRenderer::class)])
            ->tag('controller.service_arguments')
    ;
};
