<?php

declare(strict_types=1);

namespace Psi\Component\ResourceBrowser;

use Puli\Repository\Api\Resource\PuliResource;
use Puli\Repository\Api\ResourceCollection;

class Column implements \IteratorAggregate
{
    private $resource;
    private $filter;

    public function __construct(PuliResource $resource, FilterInterface $filter)
    {
        $this->resource = $resource;
        $this->filter = $filter;
    }

    public function getName(): string
    {
        return $this->resource->getName();
    }

    public function getResource(): PuliResource
    {
        return $this->resource;
    }

    public function getItems(): ResourceCollection
    {
        $resources = $this->resource->listChildren();
        $resources = $this->filter->filter($resources);

        return $resources;
    }

    public function getIterator(): ResourceCollection
    {
        return $this->getItems();
    }
}
