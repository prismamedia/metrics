# Expose metrics to Prometheus



## Usage

Require the package

```
composer require prismamedia/metrics-bundle
```

Register the bundle

```php
# config/bundles.php
return [
    // ...
    PrismaMedia\MetricsBundle\PrismaMediaMetricsBundle::class => ['all' => true],
    // ...
];
```

Import routing file

```yaml
# config/routes.yaml
metrics:
    resource: '@PrismaMediaMetricsBundle/Resources/config/routes.yaml'
```

### Implement your own metric provider

```php
<?php
# src/Metrics/ArticleCountMetric.php

namespace App\Metrics;

use PrismaMedia\MetricsBundle\Metric;
use PrismaMedia\MetricsBundle\MetricProvider;
use PrismaMedia\MetricsBundle\MetricProvider\ConnectionAwareMetricProvider;

class ArticleCountMetric implements MetricProvider
{
    // Inject the Doctrine DBAL Connection
    use ConnectionAwareMetricProvider;
    
    public function getMetrics()
    {
        $qbd = $this->connection->createQueryBuilder();
        $qbd->select('a.status, COUNT(*) as total')
            ->from('article', 'a')
            ->groupBy('a.status');

        foreach ($qbd->execute()->fetchAll() as $row) {
            yield new Metric('app_article_total', (int) $row['total'], [
                'status' => $row['status'],
            ]);
        }
    }
}
```

```yaml
# config/services.yaml
services:
    App\Metrics\:
        resource: '../src/Metrics'
        tags: ['prisma_media.metric']
```

```
# curl https://localhost:8080/metrics
app_article_total{status=published} 230
app_article_total{status=review} 2
app_article_total{status=draft} 5
```