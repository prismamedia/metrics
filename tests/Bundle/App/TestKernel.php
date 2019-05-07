<?php

namespace PrismaMedia\Metrics\Tests\Bundle\App;

use PrismaMedia\Metrics\Bundle\PrismaMediaMetricsBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader\DirectoryLoader;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\RouteCollectionBuilder;

/**
 * Kernel for functional tests.
 */
class TestKernel extends Kernel
{
    use MicroKernelTrait;

    public function registerBundles()
    {
        yield new FrameworkBundle();
        yield new PrismaMediaMetricsBundle();
    }

    protected function configureRoutes(RouteCollectionBuilder $routes)
    {
        $routes->import('@PrismaMediaMetricsBundle/Resources/config/routes.xml');
    }

    protected function configureContainer(ContainerBuilder $c, LoaderInterface $loader)
    {
        $c->loadFromExtension('framework', [
            'secret' => 'Chut!',
            'test' => true,
        ]);

        $loader = new DirectoryLoader($c, new FileLocator(__DIR__));
        $prototype = new Definition();
        $prototype
            ->setPrivate(true)
            ->setAutoconfigured(true)
            ->setAutowired(true)
            ->setTags(['prisma_media.metric' => []]);
        $loader->registerClasses($prototype, 'PrismaMedia\\Metrics\\Tests\\Bundle\\App\\Metrics\\', 'Metrics/*');
    }
}
