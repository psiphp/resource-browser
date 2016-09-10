<?php

declare(strict_types=1);

namespace Psi\Component\ResourceBrowser;

use Puli\Repository\Api\Resource\PuliResource;
use Psi\Component\Description\DescriptionFactory;
use Puli\Repository\Api\ResourceCollection;

class Column implements \IteratorAggregate
{
    private $resource;

    public function __construct(PuliResource $resource)
    {
        $this->resource = $resource;
    }

    public function getName(): string
    {
        return $this->resource->getName();
    }

    public function getResource(): PuliResource
    {
        return $this->resource;
    }

    public function getIterator(): ResourceCollection
    {
        return $this->resource->listChildren();
    }
}
