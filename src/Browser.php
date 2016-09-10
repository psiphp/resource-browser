<?php

declare(strict_types=1);

namespace Psi\Component\ResourceBrowser;

use Puli\Repository\Api\ResourceRepository;
use Psi\Component\ResourceBrowser\Column;

class Browser
{
    private $repository;
    private $nbColumns;
    private $path;

    public function __construct(ResourceRepository $repository, $path = '/', $nbColumns = 4)
    {
        $this->repository = $repository;
        $this->nbColumns = $nbColumns;
        $this->path = $path;
    }

    public function getColumns()
    {
        $columnPaths = $this->getColumnPaths($this->path);
        return $this->getColumnsForPaths($columnPaths);
    }

    public function getColumnsForDisplay()
    {
        $columnPaths = $this->getColumnPaths($this->path);

        if (count($columnPaths) > $this->nbColumns) {
            $columnPaths = array_slice($columnPaths, -$this->nbColumns);
        }

        return $this->getColumnsForPaths($columnPaths);
    }

    public function getCurrentColumn()
    {
        return new Column($this->repository->get($this->path));
    }

    public function getPath()
    {
        return $this->path;
    }

    private function getColumnsForPaths(array $columnPaths)
    {
        $columns = [];

        foreach ($columnPaths as $columnPath) {
            $resource = $this->repository->get($columnPath);
            $columns[] = new Column($resource);
        }

        return $columns;
    }

    private function getColumnPaths($path)
    {
        $columnNames = [ '/' ];

        if ($path !== '/') {
            $columnNames = explode('/', ltrim($path, '/'));
            array_unshift($columnNames, '/');
        }


        $columnPaths = [];

        foreach ($columnNames as $columnName) {
            if ($columnName !== '/') {
                $elements[] = $columnName;
            }

            $columnPaths[] = empty($elements) ? '/' : '/' . implode('/', $elements);
        }

        return $columnPaths;
    }
}
