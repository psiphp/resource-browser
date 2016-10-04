<?php

declare(strict_types=1);

namespace Psi\Component\ResourceBrowser;

use Psi\Component\ResourceBrowser\Filter\Filter\PassThroughFilter;
use Psi\Component\ResourceBrowser\Filter\FilterInterface;
use Puli\Repository\Api\ResourceRepository;

final class Browser
{
    private $repository;
    private $nbColumns;
    private $path;
    private $filter;

    private function __construct(ResourceRepository $repository, FilterInterface $filter, string $path, int $nbColumns)
    {
        $this->repository = $repository;
        $this->nbColumns = $nbColumns;
        $this->path = $path;
        $this->filter = $filter;
    }

    public static function createFromOptions(ResourceRepository $repository, array $options = [])
    {
        $defaultOptions = [
            'path' => '/',
            'nb_columns' => 4,
            'filter' => new PassThroughFilter(),
        ];

        if ($diff = array_diff(array_keys($options), array_keys($defaultOptions))) {
            throw new \InvalidArgumentException(sprintf(
                'Invalid options: "%s". Valid options: "%s"',
                implode('", "', $diff),
                implode('", "', array_keys($defaultOptions))
            ));
        }

        $options = array_merge($defaultOptions, $options);

        $browser = new self(
            $repository,
            $options['filter'],
            $options['path'],
            $options['nb_columns']
        );

        return $browser;
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
        return new Column($this->repository->get($this->path), $this->filter);
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getMaxColumns()
    {
        return $this->nbColumns;
    }

    private function getColumnsForPaths(array $columnPaths)
    {
        $columns = [];

        foreach ($columnPaths as $columnPath) {
            $resource = $this->repository->get($columnPath);
            $columns[] = new Column($resource, $this->filter);
        }

        return $columns;
    }

    private function getColumnPaths($path)
    {
        $columnNames = ['/'];

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
