<?php

namespace Psi\Component\ResourceBrowser\Tests\Unit;

use Psi\Component\ResourceBrowser\FilterInterface;
use Psi\Component\ResourceBrowser\FilterRegistry;

class FilterRegistryTest extends \PHPUnit_Framework_TestCase
{
    private $registry;

    public function setUp()
    {
        $this->filter1 = $this->prophesize(FilterInterface::class);
        $this->registry = new FilterRegistry([
            'one' => $this->filter1->reveal(),
        ]);
    }

    /**
     * It should return the named filter.
     */
    public function testReturnNamedFilter()
    {
        $filter = $this->registry->get('one');
        $this->assertSame($this->filter1->reveal(), $filter);
    }

    /**
     * It should throw an exception if the filter is not known.
     *
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Unknown filter "five". Known filters: "one"
     */
    public function testThrowExceptionNotFound()
    {
        $this->registry->get('five');
    }
}
