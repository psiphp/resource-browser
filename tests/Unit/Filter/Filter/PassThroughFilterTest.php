<?php

namespace Psi\Component\ResourceBrowser\Tests\Unit\Filter\Filter;

use Psi\Component\ResourceBrowser\Filter\Filter\PassThroughFilter;
use Puli\Repository\Api\ResourceIterator;

class PassThroughFilterTest extends \PHPUnit_Framework_TestCase
{
    private $iterator;
    private $filter;

    public function setUp()
    {
        $this->filter = new PassThroughFilter();
        $this->iterator = $this->prophesize(ResourceIterator::class);
    }

    /**
     * It should return the same iterator that was passed to it.
     */
    public function testPassThrough()
    {
        $iterator = $this->filter->filter($this->iterator->reveal());
        $this->assertSame($this->iterator->reveal(), $iterator);
    }
}
