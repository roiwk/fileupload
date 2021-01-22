<?php

namespace Roiwk\FileUpload\Core;

class PathSolver
{
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function bufferPath(string $filename): string
    {
        return $this->config->get('buffer_dir') . DIRECTORY_SEPARATOR . $this->subDir($filename);
    }

    public function filePath(string $filename): string
    {
        return $this->config->get('store_dir') . DIRECTORY_SEPARATOR . $this->subDir($filename);
    }

    public function subDir(string $filename): string
    {
        return md5($filename);
    }


}