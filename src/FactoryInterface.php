<?php

namespace Psi\Component\ResourceBrowser;

use Puli\Repository\Api\ResourceRepository;
use Psi\Component\ResourceBrowser\Context;

interface FactoryInterface
{
    public function create(Context $context);
}
