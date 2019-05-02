<?php

namespace PrismaMedia\MetricsBundle;

/**
 * A single metric.
 *
 * @see https://prometheus.io/docs/concepts/data_model/
 */
final class Metric
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var mixed
     */
    private $value;

    /**
     * @var array
     */
    private $labels = [];

    /**
     * @param string $name
     * @param mixed  $value
     * @param array  $labels
     */
    public function __construct($name, $value, array $labels = [])
    {
        $this->name = $name;
        $this->value = $value;
        $this->labels = $labels;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return array
     */
    public function getLabels()
    {
        return $this->labels;
    }

    /**
     * @return bool
     */
    public function hasLabels()
    {
        return \count($this->labels) > 0;
    }
}
