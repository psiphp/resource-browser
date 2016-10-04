<?php

declare(strict_types=1);

namespace Psi\Component\ResourceBrowser\Filter;

class AcceptorRegistry implements AcceptorRegistryInterface
{
    private $filters;

    public function __construct(array $filters)
    {
        array_map(function (AcceptorInterface $filter) {
        }, $filters);

        $this->filters = $filters;
    }

    /**
     * {@inheritdoc}
     */
    public function get($name): AcceptorInterface
    {
        if (!isset($this->filters[$name])) {
            throw new \InvalidArgumentException(sprintf(
                'Unknown filter acceptor "%s". Known filter acceptors: "%s"',
                $name, implode('", "', array_keys($this->filters))
            ));
        }

        return $this->filters[$name];
    }

    /**
     * {@inheritdoc}
     */
    public function keys(): array
    {
        return array_keys($this->filters);
    }
}
