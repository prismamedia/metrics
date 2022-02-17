<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use PrismaMedia\Metrics\Bundle\Controller\MetricsController;
use PrismaMedia\Metrics\Bundle\PrismaMediaMetricsBundle;
use PrismaMedia\Metrics\MetricAggregator;
use PrismaMedia\Metrics\MetricRenderer;
use Symfony\Component\DependencyInjection\Exception\LogicException;
use function function_exists;
use function sprintf;

return function (ContainerConfigurator $configurator) {

    $functionRef = sprintf('%s\ref', __NAMESPACE__);
    $functionService = sprintf('%s\service', __NAMESPACE__);

    $function = function_exists($functionService) ? $functionService : $functionRef;

    if (!function_exists($function)) {
        throw new LogicException(
            sprintf('Function "%s" is missing and or not supported by the used Symfony version.', $function)
        );
    }

    $configurator->services()
        ->set(MetricAggregator::class)
            ->args([tagged_iterator(PrismaMediaMetricsBundle::TAG_METRIC)])

        ->set(MetricRenderer::class)

        ->set(MetricsController::class)
            ->args([$function(MetricAggregator::class), $function(MetricRenderer::class)])
            ->tag('controller.service_arguments')
    ;
};
