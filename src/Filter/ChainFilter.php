<?php

declare(strict_types=1);

namespace Psi\Component\ResourceBrowser\Filter;

use Psi\Component\ResourceBrowser\FilterInterface;
use Puli\Repository\Api\ResourceCollection;

class ChainFilter implements FilterInterface
{
    private $filters;

    public function __construct(array $filters = [])
    {
        array_map(function (FilterInterface $filter) {
        }, $filters);

        $this->filters = $filters;
    }

    /**
     * {@inheritdoc}
     */
    public function filter(ResourceCollection $collection): ResourceCollection
    {
        foreach ($this->filters as $filter) {
            $collection = $filter->filter($collection);
        }

        return $collection;
    }
}
