# Prometheus exporter for your own metrics

This package is a Symfony bundle for [exporting metrics to Prometheus](https://prometheus.io/docs/instrumenting/writing_exporters/).
Create your own `MetricGenerator` services to generate values on-demand en expose them under the `/metrics` endpoint.

*It does not expose any metric, you have to code your own.*

## Usage

Require the package

```
composer require prismamedia/metrics
```

Register the bundle

```php
# config/bundles.php
return [
    // ...
    PrismaMedia\Metrics\Bundle\PrismaMediaMetricsBundle::class => ['all' => true],
    // ...
];
```

Import routing file

```yaml
# config/routes.yaml
metrics:
    resource: '@PrismaMediaMetricsBundle/Resources/config/routes.xml'
```

### Implement your own metric generator

Your metrics are generated on demand by a class implementing

The best practice is to create a distinct classes for distinct metric names.
Each class can returns several values with distinct labels.

In the following example, we expose a metric named `app_article_total`
labelled with each `status`. In Prometheus (& Grafana), the values can be added
in order to get the overall total.

```php
<?php
# src/Metrics/ArticleCountMetric.php

namespace App\Metrics;

use Doctrine\DBAL\Connection;
use PrismaMedia\Metrics\Metric;
use PrismaMedia\Metrics\MetricGenerator;

class ArticleCountMetric implements MetricGenerator
{
    private $connection;
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getMetrics(): \Traversable
    {
        // SELECT a.status, COUNT(*) as total FROM article GROUP BY a.status
        $qbd = $this->connection->createQueryBuilder();
        $qbd->select('a.status, COUNT(*) as total')
            ->from('article', 'a')
            ->groupBy('a.status');

        foreach ($qbd->execute()->fetchAll() as $row) {
            // app_article_total{status=<status>} <total>
            yield new Metric('app_article_total', (int) $row['total'], [
                'status' => $row['status'],
            ]);
        }
    }
}
```

Declare the service in Symfony with the tag `prisma_media.metric`.

```yaml
# config/services.yaml
services:
    App\Metrics\:
        resource: '../src/Metrics'
        tags: ['prisma_media.metric']
```

The `/metrics` endpoint will return something like this:

```
# curl https://localhost:8080/metrics
app_article_total{status=published} 230
app_article_total{status=review} 2
app_article_total{status=draft} 5
```
