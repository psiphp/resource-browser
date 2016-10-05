<?php

declare(strict_types=1);

namespace Psi\Component\ResourceBrowser\Filter\Acceptor;

use Psi\Component\ResourceBrowser\Filter\AcceptorInterface;
use Puli\Repository\Api\Resource\PuliResource;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Only accept resources if their name matches a given regex pattern.
 */
class NameAcceptor implements AcceptorInterface
{
    public function accept(PuliResource $object, array $options): bool
    {
        $match = (bool) preg_match('{' . $options['pattern'] . '}', $object->getName());

        return $options['inverse'] ? !$match : $match;
    }

    public function configureOptions(OptionsResolver $options)
    {
        $options->setRequired('pattern');
        $options->setDefault('inverse', false);
    }
}
