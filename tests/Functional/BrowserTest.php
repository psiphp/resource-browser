<?php

namespace Psi\Component\ResourceBrowser\Tests\Functional;

use Psi\Component\ResourceBrowser\Browser;
use Puli\Repository\FilesystemRepository;

class BrowserTest extends \PHPUnit_Framework_TestCase
{
    public function testBrowser()
    {
        $repository = new FilesystemRepository(__DIR__ . '/files');

        $browser = Browser::createFromOptions($repository, [
            'nb_columns' => 4,
            'path' => '/folder1',
        ]);

        $columns = $browser->getColumnsForDisplay();
        $columnOne = iterator_to_array($columns[0]);
        $columnTwo = iterator_to_array($columns[1]);

        $this->assertCount(2, $columns);
        $this->assertCount(5, $columnOne);
        $this->assertCount(3, $columnTwo);

        $this->assertArrayHasKey('/one-three.txt', $columnOne);
        $this->assertArrayHasKey('/one.txt', $columnOne);
        $this->assertArrayHasKey('/three.txt', $columnOne);
        $this->assertArrayHasKey('/two.txt', $columnOne);

        $this->assertArrayHasKey('/folder1/five-three.txt', $columnTwo);
        $this->assertArrayHasKey('/folder1/five.txt', $columnTwo);
        $this->assertArrayHasKey('/folder1/four.txt', $columnTwo);
    }
}
