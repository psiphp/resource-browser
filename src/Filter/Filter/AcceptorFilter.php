<?php

declare(strict_types=1);

namespace Psi\Component\ResourceBrowser\Filter\Filter;

use Psi\Component\ResourceBrowser\Filter\AcceptorIterator;
use Psi\Component\ResourceBrowser\Filter\AcceptorRegistryInterface;
use Psi\Component\ResourceBrowser\Filter\FilterInterface;
use Puli\Repository\Api\ResourceIterator;

/**
 * Filter which uses configured "acceptors".
 *
 * This allows inline filter specifications, e.g.:
 *
 *     filters:
 *         - { type: "name", { "pattern": "^psict:" } }
 */
class AcceptorFilter implements FilterInterface
{
    private $registry;
    private $configs;

    public function __construct(AcceptorRegistryInterface $registry, array $configs)
    {
        $this->registry = $registry;
        $this->configs = $configs;
    }

    /**
     * {@inheritdoc}
     */
    public function filter(ResourceIterator $collection): ResourceIterator
    {
        return new AcceptorIterator($collection, $this->registry, $this->configs);
    }
}
