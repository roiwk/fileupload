<?php

namespace Roiwk\FileUpload;

use Psr\Container\ContainerInterface;
use Roiwk\FileUpload\Exception\NotFoundException;
use Roiwk\FileUpload\Exception\ContainerException;

class UploaderContainer implements ContainerInterface
{

    public function __construct(array $config)
    {

    }

    public function singleton(string $abstract, array $args = [])
    {
        
    }

    public function get($name)
    {
        // throw new NotFoundException();
        // throw new ContainerException();
        return;
    }


    public function has($name)
    {
        return true;
    }
}