<?php

namespace PrismaMedia\MetricsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('prismamedia_metrics');

        return $treeBuilder;
    }
}
