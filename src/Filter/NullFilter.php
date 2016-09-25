<?php

declare(strict_types=1);

namespace Psi\Component\ResourceBrowser\Filter;

use Psi\Component\ResourceBrowser\FilterInterface;
use Puli\Repository\Api\ResourceCollection;

class NullFilter implements FilterInterface
{
    /**
     * {@inheritdoc}
     */
    public function filter(ResourceCollection $collection): ResourceCollection
    {
        return $collection;
    }
}
