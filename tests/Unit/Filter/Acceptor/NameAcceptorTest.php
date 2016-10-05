<?php

namespace Psi\Component\ResourceBrowser\Tests\Unit\Filter\Acceptor;

use Psi\Component\ResourceBrowser\Filter\Acceptor\NameAcceptor;
use Puli\Repository\Api\Resource\PuliResource;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
            'inverse' => false,
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
            'inverse' => false,
        ]);

        $this->assertFalse($accepted);
    }

    /**
     * It should accept a resource if its name does not match and inverse is true.
     */
    public function testRejectInverse()
    {
        $this->resource->getName()->willReturn('hello world');
        $accepted = $this->acceptor->accept($this->resource->reveal(), [
            'pattern' => 'foobar',
            'inverse' => true,
        ]);

        $this->assertTrue($accepted);
    }

    /**
     * It should configure options.
     */
    public function testConfigureOptions()
    {
        $options = new OptionsResolver();
        $this->acceptor->configureOptions($options);
    }
}
