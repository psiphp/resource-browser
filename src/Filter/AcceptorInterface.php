<?php

declare(strict_types=1);

namespace Psi\Component\ResourceBrowser\Filter;

use Puli\Repository\Api\Resource\PuliResource;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Acceptors decide if a given resource should be included in a filtered
 * iterator.
 */
interface AcceptorInterface
{
    public function accept(PuliResource $resource, array $options): bool;

    public function configureOptions(OptionsResolver $options);
}
