<?php

namespace Psi\Component\ResourceBrowser\Tests\Unit\Filter;

use Psi\Component\ResourceBrowser\Filter\NullFilter;
use Puli\Repository\Api\ResourceCollection;

class NullFilterTest extends \PHPUnit_Framework_TestCase
{
    private $collection;
    private $filter;

    public function setUp()
    {
        $this->collection = $this->prophesize(ResourceCollection::class);
        $this->filter = new NullFilter();
    }

    /**
     * It should return the same collection that was passed to it.
     */
    public function testFilter()
    {
        $collection = $this->filter->filter($this->collection->reveal());
        $this->assertSame($collection, $this->collection->reveal());
    }
}
