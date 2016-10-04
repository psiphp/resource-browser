<?php

namespace Psi\Component\ResourceBrowser\Tests\Unit\Filter;

use Psi\Component\ResourceBrowser\Filter\AcceptorInterface;
use Psi\Component\ResourceBrowser\Filter\AcceptorRegistry;

class AcceptorRegistryTest extends \PHPUnit_Framework_TestCase
{
    private $registry;
    private $acceptor;

    public function setUp()
    {
        $this->acceptor = $this->prophesize(AcceptorInterface::class);
        $this->registry = new AcceptorRegistry([
            'one' => $this->acceptor->reveal(),
        ]);
    }

    /**
     * It should return the named acceptor.
     */
    public function testReturnNamedFilter()
    {
        $filter = $this->registry->get('one');
        $this->assertSame($this->acceptor->reveal(), $filter);
    }

    /**
     * It should throw an exception if the filter is not known.
     *
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Unknown filter acceptor "five". Known filter acceptors: "one"
     */
    public function testThrowExceptionNotFound()
    {
        $this->registry->get('five');
    }
}
