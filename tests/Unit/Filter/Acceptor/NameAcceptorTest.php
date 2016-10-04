<?php

namespace Psi\Component\ResourceBrowser\Tests\Unit\Filter\Acceptor;

use Psi\Component\ResourceBrowser\Filter\Acceptor\NameAcceptor;
use Puli\Repository\Api\Resource\PuliResource;

class NameAcceptorTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->acceptor = new NameAcceptor();
        $this->resource = $this->prophesize(PuliResource::class);
    }

    /**
     * It should accept a resource if its name matches the given regex pattern.
     */
    public function testAccept()
    {
        $this->resource->getName()->willReturn('hello world');
        $accepted = $this->acceptor->accept($this->resource->reveal(), [
            'pattern' => 'hello',
        ]);

        $this->assertTrue($accepted);
    }

    /**
     * It should reject a resource if its name does not match the given regex pattern.
     */
    public function testReject()
    {
        $this->resource->getName()->willReturn('hello world');
        $accepted = $this->acceptor->accept($this->resource->reveal(), [
            'pattern' => 'foobar',
        ]);

        $this->assertFalse($accepted);
    }
}
