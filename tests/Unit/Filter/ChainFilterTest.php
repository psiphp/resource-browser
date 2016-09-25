<?php

namespace Psi\Component\ResourceBrowser\Tests\Unit\Filter;

use Prophecy\Argument;
use Psi\Component\ResourceBrowser\Filter\ChainFilter;
use Psi\Component\ResourceBrowser\FilterInterface;
use Puli\Repository\Api\ResourceCollection;

class ChainFilterTest extends \PHPUnit_Framework_TestCase
{
    private $chainFilter;
    private $filter1;
    private $filter2;

    public function setUp()
    {
        $this->filter1 = $this->prophesize(FilterInterface::class);
        $this->filter2 = $this->prophesize(FilterInterface::class);
        $this->collection1 = $this->prophesize(ResourceCollection::class);
        $this->collection2 = $this->prophesize(ResourceCollection::class);
        $this->collection3 = $this->prophesize(ResourceCollection::class);

        $this->chainFilter = new ChainFilter([
            $this->filter1->reveal(),
            $this->filter2->reveal(),
        ]);
    }

    /**
     * It should execute each filter.
     */
    public function testFilter()
    {
        $this->filter1->filter(Argument::is($this->collection1->reveal()))->willReturn(
            $this->collection2->reveal()
        );
        $this->filter2->filter(Argument::is($this->collection2->reveal()))->willReturn(
            $this->collection3->reveal()
        );

        $collection = $this->chainFilter->filter($this->collection1->reveal());
        $this->assertSame($collection, $this->collection3->reveal());
    }
}
