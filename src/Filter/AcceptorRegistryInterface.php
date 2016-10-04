<?php

namespace Psi\Component\ResourceBrowser\Filter;

/**
 * Registry for filter acceptors.
 */
interface AcceptorRegistryInterface
{
    /**
     * Return the named acceptor.
     */
    public function get($acceptorName): AcceptorInterface;

    /**
     * Return the names of all the registered acceptors.
     *
     * e.g. `[ "name", "description_mimetype", ... ]`
     */
    public function keys(): array;
}
