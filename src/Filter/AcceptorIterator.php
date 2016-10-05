<?php

declare(strict_types=1);

namespace Psi\Component\ResourceBrowser\Filter;

use Puli\Repository\Api\ResourceIterator;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Iterator which filters based on configured acceptors.
 */
class AcceptorIterator extends \FilterIterator implements ResourceIterator
{
    private $acceptorRegistry;
    private $filterConfigs = [];

    public function __construct(ResourceIterator $iterator, AcceptorRegistryInterface $acceptorRegistry, array $filterConfigs)
    {
        $this->acceptorRegistry = $acceptorRegistry;
        $this->filterConfigs = $filterConfigs;
        parent::__construct($iterator);
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentResource()
    {
        return $this->getInnerIterator()->current();
    }

    /**
     * {@inheritdoc}
     */
    public function accept()
    {
        $resource = $this->getCurrentResource();

        if (empty($this->filterConfigs)) {
            return true;
        }

        foreach ($this->filterConfigs as $i => $filterConfig) {
            list($filter, $config) = $this->resolveFilter($i, $filterConfig);

            if (false === $filter->accept($resource, $config)) {
                return false;
            }
        }

        return true;
    }

    private function resolveFilter($index, array $filterConfig)
    {
        static $filterCache = [];

        if (isset($filterCache[$index])) {
            return $filterCache[$index];
        }

        if (!isset($filterConfig['type'])) {
            throw new \InvalidArgumentException(sprintf(
                'Filter configuration has no "type" key, type must be one of: "%s"',
                implode('", "', $this->acceptorRegistry->keys())
            ));
        }

        $filter = $this->acceptorRegistry->get($filterConfig['type']);

        if ($diff = array_diff(array_keys($filterConfig), ['type', 'options'])) {
            throw new \InvalidArgumentException(sprintf(
                'Filter configurations can only have the "type" and "options" keys, got: "%s"',
                implode('", "', $diff)
            ));
        }

        $options = isset($filterConfig['options']) ? $filterConfig['options'] : [];
        $resolver = new OptionsResolver();
        $filter->configureOptions($resolver);
        $options = $resolver->resolve($options);
        $filterCache[$index] = [$filter, $options];

        return $filterCache[$index];
    }
}
