<?php

namespace Psi\Component\ResourceBrowser\Filter;

use Puli\Repository\Api\ResourceIterator;

/**
 * Filter a resource iterator.
 */
interface FilterInterface
{
    /**
     * Return a [filtered] resource iterator for the given resource iterator.
     */
    public function filter(ResourceIterator $iterator): ResourceIterator;
}
