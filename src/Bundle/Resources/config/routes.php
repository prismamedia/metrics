<?php

use PrismaMedia\Metrics\Bundle\Controller\MetricsController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return function (RoutingConfigurator $routes): void {
    $routes->add('prisma_media_metrics', '/metrics')
        ->controller(MetricsController::class)
    ;
};
