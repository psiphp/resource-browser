<?php

namespace Psi\Component\ResourceBrowser\Tests\Functional;

use Psi\Component\ResourceBrowser\Column;
use Psi\Component\ResourceBrowser\Filter\Acceptor\NameAcceptor;
use Psi\Component\ResourceBrowser\Filter\AcceptorRegistry;
use Psi\Component\ResourceBrowser\Filter\Filter\AcceptorFilter;
use Puli\Repository\FilesystemRepository;

class AcceptorFilterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * It should filter.
     */
    public function testAcceptorFilter()
    {
        $repository = new FilesystemRepository(__DIR__ . '/files');
        $resource = $repository->get('/');

        $acceptorRegistry = new AcceptorRegistry([
            'name' => new NameAcceptor(),
        ]);
        $acceptorFilter = new AcceptorFilter($acceptorRegistry, [
            ['type' => 'name', 'options' => ['pattern' => '.*three.*']],
        ]);
        $column = new Column($resource, $acceptorFilter);

        $resources = iterator_to_array($column);
        $this->assertCount(2, $resources);
        $this->assertArrayHasKey('/three.txt', $resources);
        $this->assertArrayHasKey('/one-three.txt', $resources);
    }
}
