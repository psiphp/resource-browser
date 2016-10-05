<?php

declare(strict_types=1);

namespace Psi\Component\ResourceBrowser;

use Psi\Component\ResourceBrowser\Filter\FilterInterface;
use Puli\Repository\Api\Resource\PuliResource;
use Puli\Repository\Api\ResourceIterator;
use Puli\Repository\Resource\Iterator\RecursiveResourceIteratorIterator;
use Puli\Repository\Resource\Iterator\ResourceCollectionIterator;

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

    public function getItems(): ResourceIterator
    {
        $resources = $this->resource->listChildren();
        $resources = new ResourceCollectionIterator($resources);
        $resources = $this->filter->filter($resources);

        return $resources;
    }

    public function getIterator(): ResourceIterator
    {
        return $this->getItems();
    }
}
