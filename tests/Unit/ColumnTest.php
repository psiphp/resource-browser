<?php

declare(strict_types=1);

namespace Psi\Component\ResourceBrowser\Tests\Unit;

use Prophecy\Argument;
use Psi\Component\ResourceBrowser\Column;
use Psi\Component\ResourceBrowser\Filter\FilterInterface;
use Puli\Repository\Api\Resource\PuliResource;
use Puli\Repository\Api\ResourceCollection;
use Puli\Repository\Api\ResourceIterator;

class ColumnTest extends \PHPUnit_Framework_TestCase
{
    private $column;

    public function setUp()
    {
        $this->resource0 = $this->prophesize(PuliResource::class);
        $this->resourceCollection = $this->prophesize(ResourceCollection::class);
        $this->filteredIterator = $this->prophesize(ResourceIterator::class);
        $this->filter = $this->prophesize(FilterInterface::class);

        $this->column = new Column($this->resource0->reveal(), $this->filter->reveal());

        $this->filter->filter(Argument::type(ResourceIterator::class))->willReturn(
            $this->filteredIterator->reveal()
        );
    }

    /**
     * It should return the column name.
     */
    public function testReturnColumnName()
    {
        $this->resource0->getName()->willReturn('hello');
        $this->assertEquals('hello', $this->column->getName());
    }

    /**
     * It should iterate over the resources in the column.
     */
    public function testIterate()
    {
        $this->resource0->listChildren()->willReturn($this->resourceCollection->reveal());

        $this->assertInstanceOf(\IteratorAggregate::class, $this->column);
        $this->assertInstanceOf(ResourceIterator::class, $this->column->getIterator());
    }

    /**
     * It should return filtered items.
     */
    public function testFilter()
    {
        $this->resource0->listChildren()->willReturn($this->resourceCollection->reveal());
        $this->filter->filter(Argument::type(ResourceIterator::class))->willReturn(
            $this->filteredIterator->reveal()
        );
        $collection = $this->column->getItems();

        $this->assertSame($this->filteredIterator->reveal(), $collection);
    }

    /**
     * It should return the resource.
     */
    public function testReturnResource()
    {
        $this->assertSame($this->resource0->reveal(), $this->column->getResource());
    }
}
