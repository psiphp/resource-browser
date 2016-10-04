<?php

declare(strict_types=1);

namespace Psi\Component\ResourceBrowser\Filter\Filter;

use Psi\Component\ResourceBrowser\Filter\FilterInterface;
use Puli\Repository\Api\ResourceIterator;

/**
 * Filter which does ... nothing.
 */
class PassThroughFilter implements FilterInterface
{
    /**
     * {@inheritdoc}
     */
    public function filter(ResourceIterator $iterator): ResourceIterator
    {
        return $iterator;
    }
}
