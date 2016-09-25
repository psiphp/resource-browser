<?php

namespace Psi\Component\ResourceBrowser;

use Puli\Repository\Api\ResourceCollection;

interface FilterInterface
{
    public function filter(ResourceCollection $collection): ResourceCollection;
}
