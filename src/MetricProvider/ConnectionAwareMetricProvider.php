<?php

namespace PrismaMedia\MetricsBundle\MetricProvider;

use Doctrine\DBAL\Connection;

trait ConnectionAwareMetricProvider
{
    /**
     * @var Connection
     */
    protected $connection;

    /**
     * @required
     *
     * @param Connection $connection
     */
    public function setConnection(Connection $connection)
    {
        $this->connection = $connection;
    }
}
