<?php

namespace Psi\Component\ResourceBrowser\Tests\Unit\Filter;

use Prophecy\Argument;
use Psi\Component\ResourceBrowser\Filter\AcceptorInterface;
use Psi\Component\ResourceBrowser\Filter\AcceptorIterator;
use Psi\Component\ResourceBrowser\Filter\AcceptorRegistryInterface;
use Puli\Repository\Api\Resource\PuliResource;
use Puli\Repository\Resource\Collection\ArrayResourceCollection;
use Puli\Repository\Resource\Iterator\ResourceCollectionIterator;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AcceptorIteratorTest extends \PHPUnit_Framework_TestCase
{
    private $iterator;
    private $acceptorRegistry;

    public function setUp()
    {
        $this->resource1 = $this->prophesize(PuliResource::class);
        $this->resource2 = $this->prophesize(PuliResource::class);
        $this->resource3 = $this->prophesize(PuliResource::class);

        $this->iterator = new ResourceCollectionIterator(new ArrayResourceCollection([
            $this->resource1->reveal(),
            $this->resource2->reveal(),
            $this->resource3->reveal(),
        ]));
        $this->acceptorRegistry = $this->prophesize(AcceptorRegistryInterface::class);
        $this->acceptor = $this->prophesize(AcceptorInterface::class);
    }

    /**
     * It should throw an exception if the config does not contain the "type" key.
     *
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Filter configuration has no "type" key, type must be one of: "foo", "bar"
     */
    public function testNoKey()
    {
        $this->acceptorRegistry->keys()->willReturn(['foo', 'bar']);
        $iterator = $this->createIterator([
            'foo' => ['bar'],
        ]);
        iterator_to_array($iterator);
    }

    /**
     * It should throw an exception if the config has extra keys.
     *
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Filter configurations can only have the "type" and "options" keys, got: "foo"
     */
    public function testExtraKeys()
    {
        $this->acceptorRegistry->get('bar')->willReturn($this->acceptor->reveal());
        $iterator = $this->createIterator([
            'foo' => ['type' => 'bar', 'foo' => 'zed'],
        ]);
        iterator_to_array($iterator);
    }

    /**
     * It should filter.
     */
    public function testAccept()
    {
        $this->acceptorRegistry->get('bar')->willReturn($this->acceptor->reveal());

        $this->acceptor->configureOptions(Argument::type(OptionsResolver::class))->will(function ($args) {
            $args[0]->setRequired('bar');
            $args[0]->setDefault('boo', 'baz');
        });

        $this->acceptor->accept($this->resource1->reveal(), ['bar' => 'zed', 'boo' => 'baz'])->willReturn(true);
        $this->acceptor->accept($this->resource2->reveal(), ['bar' => 'zed', 'boo' => 'baz'])->willReturn(false);
        $this->acceptor->accept($this->resource3->reveal(), ['bar' => 'zed', 'boo' => 'baz'])->willReturn(true);

        $iterator = $this->createIterator([
            ['type' => 'bar', 'options' => ['bar' => 'zed']],
        ]);

        $elements = [];
        foreach ($iterator as $element) {
            $elements[] = $element;
        }
        $this->assertCount(2, $elements);
        $this->assertSame($this->resource1->reveal(), $elements[0]);
        $this->assertSame($this->resource3->reveal(), $elements[1]);
    }

    private function createIterator(array $filterConfigs = [])
    {
        return new AcceptorIterator($this->iterator, $this->acceptorRegistry->reveal(), $filterConfigs);
    }
}
