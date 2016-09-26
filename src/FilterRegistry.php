<?php

declare(strict_types=1);

namespace Psi\Component\ResourceBrowser;

use Psi\Component\ResourceBrowser\FilterInterface;

class FilterRegistry
{
    private $filters;

    public function __construct(array $filters)
    {
        array_map(function (FilterInterface $filter) {
        }, $filters);

        $this->filters = $filters;
    }

    public function get($name): FilterInterface
    {
        if (!isset($this->filters[$name])) {
            throw new \InvalidArgumentException(sprintf(
                'Unknown filter "%s". Known filters: "%s"',
                $name, implode('", "', array_keys($this->filters))
            ));
        }

        return $this->filters[$name];
    }
}
