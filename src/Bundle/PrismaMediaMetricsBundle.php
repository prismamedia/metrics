<?php

declare(strict_types=1);

namespace PrismaMedia\Metrics\Bundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class PrismaMediaMetricsBundle extends Bundle
{
    /**
     * Tag that must be used in services configuration to register a MetricGenerator.
     */
    public const TAG_METRIC = 'prisma_media.metric';
}
