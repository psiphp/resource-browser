<?php

namespace Psi\Component\ResourceBrowser;

class Context
{
    private $browserName;
    private $repositoryName;
    private $path;

    public static function create(string $browserName, string $repositoryName, string $path)
    {
        $context = new self();
        $context->browserName = $browserName;
        $context->repositoryName = $repositoryName;
        $context->path = $path;

        return $context;
    }

    public function getBrowserName() 
    {
        return $this->browserName;
    }

    public function getRepositoryName() 
    {
        return $this->repositoryName;
    }

    public function getPath() 
    {
        return $this->path;
    }
}
