<?php

namespace Psi\Component\ResourceBrowser\Tests\Unit;

use Psi\Component\ResourceBrowser\Browser;
use Psi\Component\ResourceBrowser\Column;
use Puli\Repository\Api\Resource\PuliResource;
use Puli\Repository\Api\ResourceCollection;
use Puli\Repository\Api\ResourceRepository;

class BrowserTest extends \PHPUnit_Framework_TestCase
{
    private $repository;

    public function setUp()
    {
        $this->repository = $this->prophesize(ResourceRepository::class);
        $this->resource1 = $this->prophesize(PuliResource::class);
        $this->resource2 = $this->prophesize(PuliResource::class);
        $this->resource3 = $this->prophesize(PuliResource::class);
        $this->resource4 = $this->prophesize(PuliResource::class);
        $this->resourceCollection = $this->prophesize(ResourceCollection::class);
    }

    /**
     * It should return all the columns.
     */
    public function testReturnAllColumns()
    {
        $this->repository->get('/foo/bar/boo')->willReturn(
            $this->resource1->reveal()
        );
        $this->repository->get('/foo/bar')->willReturn(
            $this->resource2->reveal()
        );
        $this->repository->get('/foo')->willReturn(
            $this->resource3->reveal()
        );
        $this->repository->get('/')->willReturn(
            $this->resource4->reveal()
        );

        $browser = $this->createBrowser([
            'path' => '/foo/bar/boo',
            'nb_columns' =>  4,
        ]);
        $columns = $browser->getColumns();
        $this->assertCount(4, $columns);
        $this->assertContainsOnly(Column::class, $columns);

        $column1 = reset($columns);
        $this->assertSame($this->resource4->reveal(), $column1->getResource());
    }

    /**
     * It should return columns for display (as determined by $nbColumns).
     */
    public function testReturnColumnsForDisplay()
    {
        $this->repository->get('/foo/bar/boo')->willReturn(
            $this->resource1->reveal()
        );
        $this->repository->get('/foo/bar')->willReturn(
            $this->resource2->reveal()
        );

        $browser = $this->createBrowser([
            'path' => '/foo/bar/boo',
            'nb_columns' => 2,
        ]);
        $columns = $browser->getColumnsForDisplay();

        $this->assertCount(2, $columns);
        $this->assertContainsOnly(Column::class, $columns);

        $column1 = reset($columns);
        $this->assertSame($this->resource2->reveal(), $column1->getResource());
    }

    /**
     * It should return the current column.
     */
    public function testReturnCurrentColumn()
    {
        $this->repository->get('/foo/bar/boo')->willReturn(
            $this->resource1->reveal()
        );
        $this->repository->get('/foo/bar')->willReturn(
            $this->resource2->reveal()
        );

        $browser = $this->createBrowser([
            'path' => '/foo/bar/boo',
            'nb_columns' => 2,
        ]);
        $column = $browser->getCurrentColumn();

        $this->assertSame($this->resource1->reveal(), $column->getResource());
    }

    /**
     * It should return the current path.
     */
    public function testReturnPath()
    {
        $browser = $this->createBrowser([
            'path' => '/foo/bar/boo',
            'nb_columns' => 2,
        ]);
        $path = $browser->getPath();

        $this->assertEquals('/foo/bar/boo', $path);
    }

    /**
     * It should return the (max) number of columns.
     */
    public function testMaxColumns()
    {
        $browser = $this->createBrowser([
            'path' => '/foo/bar/boo',
            'nb_columns' => 2,
        ]);

        $this->assertEquals(2, $browser->getMaxColumns());
    }

    private function createBrowser(array $options = [])
    {
        return Browser::createFromOptions($this->repository->reveal(), $options);
    }
}
