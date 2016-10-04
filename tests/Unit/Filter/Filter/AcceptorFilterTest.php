<?php

namespace Psi\Component\ResourceBrowser\Tests\Unit\Filter\Filter;

use Psi\Component\ResourceBrowser\Filter\AcceptorIterator;
use Psi\Component\ResourceBrowser\Filter\AcceptorRegistryInterface;
use Psi\Component\ResourceBrowser\Filter\Filter\AcceptorFilter;
use Puli\Repository\Api\ResourceIterator;

class AcceptorFilterTest extends \PHPUnit_Framework_TestCase
{
    private $filter;
    private $registry;

    public function setUp()
    {
        $this->registry = $this->prophesize(AcceptorRegistryInterface::class);
        $this->filter = new AcceptorFilter(
            $this->registry->reveal(),
            [
                'config' => 'gifnoc',
            ]
        );

        $this->iterator = $this->prophesize(ResourceIterator::class);
    }

    /**
     * It should return an filter iterator.
     */
    public function testReturnAcceptorIterator()
    {
        $iterator = $this->filter->filter($this->iterator->reveal());
        $this->assertInstanceOf(AcceptorIterator::class, $iterator);
    }
}
